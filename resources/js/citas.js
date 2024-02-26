'use strict'

import { Calendar } from '@fullcalendar/core';
import { debounce } from 'lodash';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';
import momentPlugin from '@fullcalendar/moment';
import bootstrapPlugin from '@fullcalendar/bootstrap';
import moment from 'moment/moment';
import axios, { Axios } from 'axios';
import swal from 'sweetalert';

let calendarEl = document.getElementById('calendar');
let calendar;
const eliminados = [];

function isDateIsAvailable(date,calendar) {
    var allEvents = [];
    allEvents = calendar.getEvents();
    return allEvents.filter(val => {
        return moment(date).format("YYYY-MM-DD") == moment(val.start).format("YYYY-MM-DD") && val.extendedProps.available
    }).length > 0;
}

function removeEventById(jsEvent){
    let calendarEvent = calendar.getEventById(jsEvent.currentTarget.eventId)
   if(!calendarEvent.extendedProps.isNew){
    eliminados.push(calendarEvent.id);
   }
   calendarEvent.remove();
}

function removeScheduleById(id){
    return swal({
        title: "Cancelar cita",
        text: "¿Esta seguro de que desea cancelar la cita?",
        icon: "warning",
        buttons: ["No","SI"],
        dangerMode: true,
      })
      .then((cancelar)=>{
        if(cancelar){
            let csrfToken = document.getElementById("csrfToken").value;

            axios.delete("/cancelarCita",
            { data: {id},
            headers:{
                'X-CSRF-TOKEN': csrfToken
            }
            }).then((data) => {
                if(data.data.success) swal("Cita cancelada")
                return calendar.refetchEvents();
            }).catch(_ => genericError())

        }
      }).catch(console.log);
}

let buttonRemoveEvent = () => `
<button class="btn btn-circle btn-danger"
    style="position: absolute;z-index:2;top: 0;right: 0;/* margin: -7px -7px; */width: 15px;h;height: 15px;font-size: 13px;padding: 0;">
    <i class="fas fa-times"></i>
</button>
`;

function logEvents(){
    const events = calendar.getEvents();
    console.log(events);
}


const searchPatient = debounce((search) => {
    axios.get('/buscarPaciente',{ params: { search } })
    .then((response) => {
        const listaUsuarios = document.getElementById("listaUsuarios");
        listaUsuarios.innerHTML = "";
        response.data.forEach( user => {
            let button = document.createElement('button');
            button.className = "list-group-item list-group-item-action";
            button.id = "selectUser-"+user.id
            button.type = 'button';
            button.innerText = `${user.name} ${user.last_name} - CI ${user.ci}`
            button.addEventListener("click", () => {selectPatient(user)});
            listaUsuarios.appendChild(button);

        });
    });
},250);


function selectPatient(user){
    document.getElementById("selectedPatient").value = user.id;
    document.getElementById("listaUsuarios").innerHTML = "";
    document.getElementById("nombrePaciente").innerText = `${user.name} ${user.last_name} - CI ${user.ci}`;

}

// guardar fecha disponible
function saveAvailabilityData(){
    let idDoctor = document.getElementById("selectedDoctor").value;
    let csrfToken = document.getElementById("csrfToken").value;
    let newEvents = calendar.getEvents().filter(val => val.extendedProps.isNew).map((val) => {
        return {
            doctor_id: idDoctor,
            start: moment(val.start).format("YYYY-MM-DD HH:mm:ss"),
            end: moment(val.end).format("YYYY-MM-DD HH:mm:ss")
        }
    });

    axios.post('/agendarDisponibilidad/'+idDoctor,{
        id:idDoctor,
        eliminados,
        newEvents
    },
    {headers:{
        'X-CSRF-TOKEN': csrfToken
    }}).then((data) => {
        let result = data.data;
        if(result.success){
            location.reload();
        }
    }).catch(console.log);
}

// calendario disponibilidad
function doctorAvailabilityCalendar(){
    return new Calendar(calendarEl, {
        plugins: [ timeGridPlugin, interactionPlugin, momentPlugin, bootstrapPlugin, dayGridPlugin ],
        initialView: 'dayGridMonth',
        locale: 'es',
        selectOverlap: false,
        selectable: true,
        allDaySlot: false,
        height: 500,
        unselectAuto: false,
        nowIndicator: true,
        displayEventTime: false,
        firstDay: 1,
        longPressDelay: 200,
        eventSources: [
          {
            url: '/disponibilidadDoctor/'+document.getElementById("selectedDoctor").value,
          },
        ],
        eventAdd: function(event){
          let id = event.event.id;
          console.log({event,id})
        },

        select: function(selectionInfo){
        //   let currentMinuteTimeBlock = moment().minute() < 30 ? 0 : 30;
          if(moment(selectionInfo.start).isSameOrBefore(moment(),'day')) return
          calendar.addEvent({
              start: moment(selectionInfo.start).hour(7).minute(30).format("YYYY-MM-DD HH:mm:ss"),
              end: moment(selectionInfo.start).hour(12).minute(0).format("YYYY-MM-DD HH:mm:ss"),
              title: 'Disponible',
              id: moment().valueOf(),
              isNew: true,
          });
        },

        eventDidMount: function({event,el}){
          if(el && moment().isBefore(event.start,"day")){
              // console.log({event, el})
              let button = document.createElement('span');
              button.innerHTML = buttonRemoveEvent()
              button.eventId = event.id;
              button.addEventListener("click",removeEventById)
              el.append(button)
          }
        }


      });
}


//calendario agendar citas
function scheduleDate(){
    return new Calendar(calendarEl, {
        plugins: [ timeGridPlugin, interactionPlugin, momentPlugin, bootstrapPlugin, dayGridPlugin ],
        initialView: 'dayGridMonth',
        locale: 'es',
        selectable: true,
        allDaySlot: false,
        eventStartEditable: true,
        height: 500,
        slotMinTime: "07:30:00",
        slotMaxTime: "12:00:00",
        unselectAuto: false,
        displayEventTime: false,
        nowIndicator: true,
        firstDay: 1,
        longPressDelay: 200,
        eventSources: [

          {
            url: '/disponibilidadDoctor/'+document.getElementById("selectedDoctor").value,
            id: "disponibilidad",
            eventDisplay: 'background'
          },
          {
            url: '/citasPaciente' + "?id_doctor=" +document.getElementById("selectedDoctor").value,
            id: "citas",
          }


        ],
        eventAdd: function(event){
          let id = event.event.id;
        },

        select: function(selectionInfo){

          let currentMinuteTimeBlock = moment().minute() < 30 ? 0 : 30;
          if(moment(selectionInfo.start).isBefore(moment().minute(currentMinuteTimeBlock),'minute')) return
          if (!isDateIsAvailable(selectionInfo.start, this)) return;

          swal({
            title: "Programar cita",
            text: "¿Desea programar cita para el: " + moment(selectionInfo.start).format("YYYY-MM-DD") +"?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((schedule) => {
            if (schedule) {

                let idPatient = document.getElementById("selectedPatient").value;
                let idDoctor = document.getElementById("selectedDoctor").value;
                let csrfToken = document.getElementById("csrfToken").value;
                if(!idPatient){
                   return swal("No ha seleccionado al paciente.")
                }
                axios.post('/agendarCita/'+idDoctor,{
                    idPatient: idPatient,
                    consultation_date: moment(selectionInfo.start).format("YYYY-MM-DD ") + "07:30:00"
                },
                {headers:{
                    'X-CSRF-TOKEN': csrfToken
                }}).then((data) => {
                    let result = data.data;
                    calendar.refetchEvents();
                    if(!result.success){
                        swal({text: result.error}).then((res) => {
                            if(result.errorCode == 2){
                                return location.reload();
                            }
                            if(result.errorCode == 3){
                                return location.reload();
                            }
                        })
                    }
                    else{
                        swal({text: result.message}).then(()=>{return location.reload()})
                    }
                }).catch(_ => genericError());
            }
          });


        },

        eventDidMount: function({event,el}){

            if(el && event.extendedProps.type == "Cita" && moment().isSameOrBefore(event.start,"day")){
                // console.log({event, el})
                let button = document.createElement('span');
                button.innerHTML = buttonRemoveEvent()
                button.eventId = event.id;
                button.addEventListener("click", () => { removeScheduleById(event.extendedProps._id) })
                el.append(button)
                el.addEventListener("click", ()=>{
                    swal(
                        "Hora: " + moment(event.start).format("YYYY-MM-DD hh:mm A") + "\n" +
                        "Paciente: " + event.extendedProps.fullName + "\n"
                    );
                })
            }
        }


      });
}

document.addEventListener('DOMContentLoaded', function() {
    let calendarType = document.getElementById("calendarType");
    const saveButtons = [...document.getElementsByClassName("saveCalendarData")]
    // document.getElementById("logEvents").addEventListener("click", logEvents);

    // let user = JSON.parse(document.getElementById("user").value)

    if(!calendarType) return;

    if(calendarType.value === "doctorAvailability"){
        calendar = doctorAvailabilityCalendar();
        for (let item of saveButtons) {
            item.addEventListener("click", ()=>{
                saveAvailabilityData();
            });
        }
    }
    if(calendarType.value === "scheduleDate"){
        calendar = scheduleDate();
        const search = document.getElementById("buscadorPaciente");
        const searchButton = document.getElementById("searchButton");
        if(search && searchButton) {
            searchButton.addEventListener("click",() => {searchPatient(search.value)});
        }



    }
    if(calendar.render)
        calendar.render();
  });


