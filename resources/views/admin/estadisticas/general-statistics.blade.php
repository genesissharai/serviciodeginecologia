@extends('admin.layout')

@section('content')
    <script src="{{Vite::asset('resources/vendor/chart.js/Chart.min.js')}}"></script>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4 w-100">
                <div class="card-header p-3"><h6 class="m-0 font-weight-bold text-primary">Citas atendidas los ultimos 30 dias</h6></div>
                <div class="card-body">
                    <canvas id="citas"></canvas>
                </div>
            </div>
            <script>
                const citasCanvas = document.getElementById('citas');
                const citas = {!! json_encode($citas->toArray(), JSON_HEX_TAG) !!};
                let data_1 = [];
                citas.forEach(val => {data_1[val.status] = val.cantidad});

                new Chart(citasCanvas, {
                  type: 'pie',
                  data: {
                    labels: [
                        'Canceladas',
                        'Atendidas',
                        'No atendidas',
                        'Pendientes',
                    ],
                    datasets: [{
                        label: 'Citas',
                        data: [data_1['CANCELED'], data_1['ATTENDED'], data_1['UNATTENDED'], data_1['PENDING']],
                        backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(100, 205, 120)',
                        ],
                        hoverOffset: 4
                    }
                    ]
                 },
                  options: {
                    scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                  }
                });
              </script>
        </div>
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4 w-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cantidad promedio de citas por dia de la semana los ultimos 30 dias</h6>
                </div>
                <div class="card-body">
                    <canvas id="citas-por-dia"></canvas>
                </div>
            </div>
            <script>
                const citasPorDiaCanvas = document.getElementById('citas-por-dia');
                const citasPorDia = Object.values({!! json_encode($citasPorDia, JSON_HEX_TAG) !!});
                let atendidas = [];
                let no_atendidas = [];
                let canceladas = [];
                let pendientes = [];

                let total_atendidas = 0;
                let total_no_atendidas = 0;
                let total_canceladas = 0;
                let total_pendientes = 0;
                citasPorDia.forEach(dia => {
                    let _atendidas = dia.filter(val => val.status == "ATTENDED").map(val => val.cantidad).reduce((a, b) => a+b, 0);
                    let cantidad_atendidas = dia.filter(val => val.status == "ATTENDED").length;
                    let _no_atendidas = dia.filter(val => val.status == "UNATTENDED").map(val => val.cantidad).reduce((a, b) => a+b, 0);
                    let cantidad_no_atendidas = dia.filter(val => val.status == "UNATTENDED").length;
                    let _canceladas = dia.filter(val => val.status == "CANCELED").map(val => val.cantidad).reduce((a, b) => a+b, 0);
                    let cantidad_canceladas = dia.filter(val => val.status == "CANCELED").length;
                    let _pendientes = dia.filter(val => val.status == "PENDING").map(val => val.cantidad).reduce((a, b) => a+b, 0);
                    let cantidad_pendientes = dia.filter(val => val.status == "PENDING").length;

                    if(cantidad_atendidas){
                        atendidas.push(_atendidas / cantidad_atendidas);
                    }else{
                        atendidas.push(0);
                    }
                    if(cantidad_no_atendidas){
                        no_atendidas.push(_no_atendidas / cantidad_no_atendidas);
                    }else{
                        no_atendidas.push(0);
                    }
                    if(cantidad_canceladas){
                        canceladas.push(_canceladas / cantidad_canceladas);
                    }else{
                        canceladas.push(0);
                    }
                    if(cantidad_pendientes){
                        pendientes.push(_pendientes / cantidad_pendientes);
                    }else{
                        pendientes.push(0);
                    }
                });

                const data_2 = {
                    labels: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
                    datasets: [
                        {
                            label: 'Canceladas',
                            data: canceladas,
                            backgroundColor: 'rgb(255, 99, 132)',
                        },
                        {
                            label: 'Atendidas',
                            data: atendidas,
                            backgroundColor: 'rgb(54, 162, 235)',
                        },
                        {
                            label: 'No atendidas',
                            data: no_atendidas,
                            backgroundColor: 'rgb(255, 205, 86)',
                        },
                        {
                            label: 'Pendientes',
                            data: pendientes,
                            backgroundColor: 'rgb(100, 205, 120)',
                        },
                    ]
                };
                const config_2 = {
                    type: 'bar',
                    data: data_2,
                    options: {
                        responsive: true,
                        plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Citas por dia de la semana'
                        }
                        }
                    },
                };

                new Chart(citasPorDiaCanvas, config_2)
            </script>
        </div>
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4 w-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cantidad de doctores por tipo de jerarquia</h6>
                </div>
                <div class="card-body">
                    <canvas id="tipoDoctores"></canvas>
                </div>
            </div>
            <script>
                const tipoDoctores = document.getElementById('tipoDoctores');
                const tiposDoctoresJerarquia = Object.values({!! json_encode($doctores, JSON_HEX_TAG) !!});
                const data_3 = {
                    labels: tiposDoctoresJerarquia.map(val => val.hierarchy),
                    datasets: [
                        {
                            label: 'Jerarquia',
                            data: tiposDoctoresJerarquia.map(val => val.cantidad),
                            backgroundColor: [
                                'rgb(175, 150, 100)',
                                'rgb(255, 25, 1)',
                                'rgb(205, 75, 233)',
                                'rgb(155, 125, 0)',
                                'rgb(105, 185, 129)',
                                'rgb(55,  245, 10)',
                                'rgb(5,   50, 5)',
                                'rgb(225, 100, 5)',
                                'rgb(125, 200, 250)',
                            ],
                        }
                    ]
                };
                const config_3 = {
                    type: 'pie',
                    data: data_3,
                    options: {}
                };

                new Chart(tipoDoctores, config_3)
            </script>
        </div>
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4 w-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Asistencias a quirofano por residentes los ultimos 30 dias</h6>
                </div>
                <div class="card-body">
                    <canvas id="asistenciasQuirofanoDoctor"></canvas>
                </div>
            </div>
            <script>
                const asistenciasQuirofanoDoctor = document.getElementById('asistenciasQuirofanoDoctor');
                const asistenciasQuirofano = Object.values({!! json_encode($asistenciasQuirofano, JSON_HEX_TAG) !!});
                const data_4 = {
                    labels: asistenciasQuirofano.map(val => val.hierarchy),
                    datasets: [
                        {
                            label: 'Jerarquia',
                            data: asistenciasQuirofano.map(val => val.cantidad),
                            backgroundColor: [
                                'rgb(175, 150, 100, 0.2)',
                                'rgb(255, 25, 1, 0.2)',
                                'rgb(205, 75, 233, 0.2)',
                                'rgb(155, 125, 0, 0.2)',
                                'rgb(105, 185, 129, 0.2)',
                                'rgb(55,  245, 10, 0.2)',
                                'rgb(5,   50, 5, 0.2)',
                                'rgb(225, 100, 5, 0.2)',
                                'rgb(125, 200, 250, 0.2)',
                            ],
                        }
                    ]
                };
                const config_4 = {
                    type: 'doughnut',
                    data: data_4,
                    options: {}
                };

                new Chart(asistenciasQuirofanoDoctor, config_4)
            </script>
        </div>
        <div class="col-12">
            <div class="card shadow mb-4 w-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Morbilidad diaria ultimos 30 dias</h6>
                </div>
                <div class="card-body">
                    <canvas id="morbilidadDiaria"></canvas>
                </div>
            </div>
            <script>
                const morbilidadDiariaCanvas = document.getElementById('morbilidadDiaria');
                const morbilidadDiaria = Object.values({!! json_encode($morbilidad->toArray(), JSON_HEX_TAG) !!});
                console.log({morbilidadDiaria})
                const labels_5 = morbilidadDiaria.map(val => val.fecha);

                const data_5 = {
                    labels: labels_5,
                    datasets: [
                        {
                            label: 'Morbilidad diaria',
                            data: morbilidadDiaria.map(val => val.cantidad),
                            backgroundColor: 'rgb(255, 99, 132)',
                        },
                    ]
                };
                const config_5 = {
                    type: 'bar',
                    data: data_5,
                    options: {
                        responsive: true,
                        plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Citas por dia de la semana'
                        }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }

                    },
                };

                new Chart(morbilidadDiariaCanvas, config_5)
            </script>
        </div>
</div>
@endsection
