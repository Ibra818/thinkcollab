@extends('index')

@section('content')
<link rel="stylesheet" href=" {{ asset('css/admin-home.css') }} ">
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

 <script>
        document.addEventListener("DOMContentLoaded", () => {
            // console.log();
            new ApexCharts(document.querySelector('#home .metrics .metric-item:nth-child(1) .metric-item-graph'), {
                series: [{
                    name: 'Totals gains générés',
                    data: [95, 40, 28, 51, 42, 82, 100],
                    }, 
                    
                ],

                grid:{
                    yaxis: {
                        lines: {show: false},
                    },
                },

               chart: {
                    type: 'area',
                    height: '60%',
                    width: '100%',
                    toolbar: {
                        show: false
                    },
                },

                markers: {
                    size: 4
                },

                colors: ['#2eca6a',],

                fill: {
                    type: "solid",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 90, 100]
                    }
                },

                    dataLabels: {
                        enabled: false
                    },

                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },

                    xaxis: {
                        labels: {
                            style: {
                                colors: '#ffffff',
                            }
                        },
                        type: 'datetime',
                        lines: {show: false},
                        categories: [
                            "2018-09-19T00:00:00.000Z", 
                            "2018-09-19T01:30:00.000Z",
                            "2018-09-19T02:30:00.000Z", 
                            "2018-09-19T03:30:00.000Z",
                            "2018-09-19T04:30:00.000Z", 
                            "2018-09-19T05:30:00.000Z",
                            "2018-09-19T06:30:00.000Z"
                        ]
                    },

                    yaxis: {
                        labels:{
                                style: {
                                colors: '#ffffff',
                            },
                        }
                    },
                    

                    tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                    }
                                            
            }).render();


            new ApexCharts(document.querySelector('#home .metrics .metric-item:nth-child(2) .metric-item-graph'), {
                series: [{
                    name: 'Totals gains générés',
                    data: [60, 40, 0, 51, 42, 82, 56],
                    }, 
                    
                ],

                grid: {
                    yaxis: {lines: {show: false},},
                },

               chart: {
                    type: 'area',
                    height: '60%',
                    width: '100%',
                    toolbar: {show: false},
                },

                markers: {size: 4},

                colors: ['#0675d7ff', ],

                fill: {
                    type: "solid",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 90, 100]
                    }
                },

                    dataLabels: {
                        enabled: false
                    },

                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },

                    xaxis: {
                        labels: {
                            style: {
                                colors: '#ffffff',
                            }
                        },
                        type: 'datetime',
                        lines: {show: false},
                        categories: [
                            "2018-09-19T00:00:00.000Z", 
                            "2018-09-19T01:30:00.000Z",
                            "2018-09-19T02:30:00.000Z", 
                            "2018-09-19T03:30:00.000Z",
                            "2018-09-19T04:30:00.000Z", 
                            "2018-09-19T05:30:00.000Z",
                            "2018-09-19T06:30:00.000Z"
                        ]
                    },

                    yaxis: {
                        labels: {
                            style: {
                                colors: '#ffffff',
                            }
                        }
                    },

                    tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                    }
                                            
            }).render();

            new ApexCharts(document.querySelector('#home .metrics .metric-item:nth-child(3) .metric-item-graph'), {
                series: [{
                    name: 'Totals gains générés',
                    data: [0, 40, 28, 51, 200, 82, 0],
                    }, 
                    
                ],

                grid: {
                    yaxis: {lines: {show: false},}
                },

               chart: {
                    type: 'area',
                    height: '60%',
                    width: '100%',
                    toolbar: {
                        show: false
                    },
                },

                markers: {
                    size: 4
                },

                colors: ['#ca792eff', ],

                fill: {
                    type: "solid",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },

                    dataLabels: {
                        enabled: false
                    },

                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },

                    xaxis: {
                        labels: {
                            style: {
                                colors: '#ffffff',
                            }
                        },
                        type: 'datetime',
                        lines: {show: false},
                        categories: [
                            "2018-09-19T00:00:00.000Z", 
                            "2018-09-19T01:30:00.000Z",
                            "2018-09-19T02:30:00.000Z", 
                            "2018-09-19T03:30:00.000Z",
                            "2018-09-19T04:30:00.000Z", 
                            "2018-09-19T05:30:00.000Z",
                            "2018-09-19T06:30:00.000Z"
                        ]
                    },

                    yaxis: {
                        labels: {
                            style: {
                                colors: '#ffffff',
                            },
                        },
                    },

                    tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                    }
                                            
            }).render();

            new ApexCharts(document.querySelector('#home .metrics .metric-item:nth-child(4) .metric-item-graph'), {
                series: [{
                    name: 'Totals formateurs',
                    data: [300, 40, 28, 51, 42, 82, 0],
                    }, 
                    
                ],

                grid: { 
                    yaxis:{
                        lines: {show: false,},
                    },
                },

               chart: {
                    type: 'area',
                    height: '60%',
                    width: '100%',
                    toolbar: {
                        show: false
                    },
                },
                

                markers: {
                    size: 4
                },

                colors: ['#ca2e2eff', ],

                fill: {
                    type: "solid",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },

                    dataLabels: {
                        enabled: false
                    },

                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },

                    xaxis: {
                        labels: {
                            style: {
                                colors: '#ffffff',
                            }
                        },
                        type: 'datetime',
                        lines: {show: false},
                        categories: [
                            "2018-09-19T00:00:00.000Z", 
                            "2018-09-19T01:30:00.000Z",
                            "2018-09-19T02:30:00.000Z", 
                            "2018-09-19T03:30:00.000Z",
                            "2018-09-19T04:30:00.000Z", 
                            "2018-09-19T05:30:00.000Z",
                            "2018-09-19T06:30:00.000Z"
                        ]
                    },

                    yaxis: {
                        labels: {
                            style: {
                                colors: '#ffffff',
                            },
                        },
                        lines: {show: false},
                    },

                    tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                    }
                                            
            }).render();
        });
    </script>

    <nav>
        <div class="nav-head">
            <img src="https://www.bintschool.com/wp-content/uploads/2023/04/BintSchooloff.png" alt="" class="logo">
        </div>
        <div class="pages">
            <ul>
                MENU
                <li class="pour-toi active">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="bi bi-house" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                    </svg>
                    Accueil
                </li>

                <li class="profile-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                    Gestion des formateurs
                </li>

                <li class="messagerie-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>
                    Gestion des cours
                </li>
                <li class="forma-suivie">
                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-book-fill" viewBox="0 0 16 16">
                        <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                    </svg>    
                    Gestion des apprenants
                </li>

            </ul> 
        </div>
        

        <button id="logout">
            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
            </svg>    
        Déconnexion</button>
    </nav>

    <div id="blockpage">
            <section id="home">

                <div id="content">
                    <div class="content-head">
                        <h3>Vue d'ensemble</h3>

                        <div class="ctn-search">
                            <div class="ctn-input">
                                <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                                <input type="text" placeholder="Recherche">
                            </div>
                            <button class="btn-search">Recherche</button>
                        </div>
                    </div>

                    <div class="metrics">
                        <div class="metric-item">
                            <div class="metric-item-head">
                                <h6>Total gains générer 
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </h6>
                                <div class="gains">40000 
                                    <button>Tous
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="metric-item-graph">

                            </div>
                        </div>

                        <div class="metric-item">
                            <div class="metric-item-head">
                                <h6>Total gains apprenants
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                        </svg></button></h6>
                                <div class="gains">40000 
                                    <button>Tous
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="metric-item-graph">

                            </div>
                        </div>

                        <div class="metric-item">
                            <div class="metric-item-head">
                                <h6>Total cours publiés 
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                        </svg>    
                                    </button>
                                </h6>
                                <div class="gains">40000 
                                    <button>Tous
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="metric-item-graph">

                            </div>
                        </div>

                        <div class="metric-item">
                            <div class="metric-item-head">
                                <h6>Total formateurs 
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </h6>
                                <div class="gains">40000 
                                    <button>Tous
                                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="metric-item-graph">

                            </div>
                        </div>
                    </div>
                </div>

            </section>
    </div>

@endsection