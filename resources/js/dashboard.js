import axios from "axios";
import swal from "sweetalert";



document.addEventListener('DOMContentLoaded', ()=>{

    const btns = document.getElementsByClassName("btnCancelarCita");

    for(let btn of btns){
        btn.addEventListener("click", () => {
            return swal({
                title: "Cancelar cita",
                text: "¿Esta seguro de que desea cancelar la cita?",
                icon: "warning",
                buttons: ["No","SI"],
                dangerMode: true,
              })
              .then((cancelar)=>{
                if(cancelar){
                    axios.delete("/cancelarCita",
                    { data: {id: btn.dataset.id},
                    }).then((data) => {
                        if(data.data.success) swal("Cita cancelada")
                        return location.reload();
                    }).catch(_ => genericError())

                }
              }).catch(console.log);
        })
    }

})
