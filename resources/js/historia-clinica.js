import moment from 'moment/moment';
import axios, { Axios } from 'axios';


window.addEventListener('load',function(){

    /* const formMedicalHistory = document.getElementById("formMedicalHistory");
    if(formMedicalHistory){
        formMedicalHistory.addEventListener('submit', (e) => {
            let formData = new FormData(formMedicalHistory);
            e.preventDefault();
            let radio = $('[name="egress_reason"]:checked').val();
            console.log(radio)
            console.log([...formData.entries()])
        });
    } */
    const birthdate = document.getElementById("birthdate");
    if(birthdate){
        if(birthdate.value){
            const age = moment().diff(moment(birthdate.value),'year');
            this.document.getElementById("age").value = age;
        }

        this.document.addEventListener('change', ()=>{
            const age = moment().diff(moment(birthdate.value),'year');
            this.document.getElementById("age").value = age;
        })

    }

});
