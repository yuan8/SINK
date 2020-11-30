<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class MENUSPROVIDER extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    static $tahun_access=0;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }


    public static function getContext(Request $request ){
        dd($request);
    }

    static function dashboard(){
        static::$tahun_access=((isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'));

        $menus=[
            'side_left'=>[],
            'side_right'=>[],
            'top'=>[
               [
                    'text'=>('RKPD'),
                    'href'=>'#',
                    'top_nav_class'=>'',
                    'icon'=>null,
                    'submenu'=>[
                        [
                            'text'=>('RKPD PEMDA'),
                            'href'=>route('d.rkpd.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                            'top_nav_class'=>'',
                            'icon'=>null,
                             
                        ],
                        [
                            'text'=>('LIST RKPD (DATA SIPD)'),
                            'href'=>route('d.rkpd.pelaporan',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                            'top_nav_class'=>'',
                            'icon'=>null,
                             
                        ]

                    ]
                ],
                [
                    'text'=>('KEBIJAKAN PUSAT'),
                    'href'=>'#',
                    'top_nav_class'=>'',
                    'icon'=>null,
                    'submenu'=>[
                        [
                            'text'=>('MANDAT PUSAT'),
                            'href'=>route('d.kebijakan.pusat',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                            'top_nav_class'=>'',
                            'icon'=>null,
                             
                        ],
                        [
                            'text'=>('IMPLEMENTASI DAERAH'),
                            'href'=>route('d.kebijakan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                            'top_nav_class'=>'',
                            'icon'=>null,
                             
                        ]

                    ]
                ],
                [
                    'text'=>('RPJMN'),
                    'href'=>'#',
                    'top_nav_class'=>'',
                    'icon'=>null,
                    'submenu'=>[
                        [
                            'text'=>('PEMETAAN PUSAT'),
                            'href'=>route('d.rpjmn.pusat',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                            'top_nav_class'=>'',
                            'icon'=>null,
                             
                        ],
                        [
                            'text'=>('IMPLEMENTASI DALAM REKOMENDASI RKPD'),
                            'href'=>route('d.kebijakan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                            'top_nav_class'=>'',
                            'icon'=>null,
                             
                        ]

                    ]
                ],
                [
                    'text'=>('RKP'),
                    'href'=>'#',
                    'top_nav_class'=>'',
                    'icon'=>null,
                    'submenu'=>[
                        [
                            'text'=>('PEMETAAN PUSAT'),
                            'href'=>route('d.kebijakan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                            'top_nav_class'=>'',
                            'icon'=>null,
                             
                        ],
                        [
                            'text'=>('IMPLEMENTASI DALAM REKOMENDASI RKPD'),
                            'href'=>route('d.kebijakan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                            'top_nav_class'=>'',
                            'icon'=>null,
                             
                        ]

                    ]
                ],
                [
                    'text'=>('INDIKATOR'),
                    'href'=>route('sink.pusat.kebijakan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                    'top_nav_class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>('REKOMENDASI RKPD'),
                    'href'=>route('sink.pusat.kebijakan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                    'top_nav_class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>('SINKRONISASI RKPD'),
                    'href'=>route('sink.pusat.kebijakan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                    'top_nav_class'=>'',
                    'icon'=>null
                ]
            ]
        ];

        return $menus;
    }

    static function admin(){
        $menus=[
            'side_left'=>[
                'MASTERING DATA',
                [
                    'text'=>'SDGS',
                    'href'=>route('sink.admin.sdgs.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'NOMENKLATUR',
                    'href'=>route('sink.pusat.kebijakan5.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'RKPD '.((isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')),
                    'href'=>route('sink.pusat.kebijakan5.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                'AKSESING',
                   [
                    'text'=>'DESK SCHEDULE',
                    'href'=>route('sink.pusat.kebijakan5.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'USERS',
                    'href'=>route('sink.pusat.kebijakan5.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],



            ],
            'side_right'=>[],
            'top'=>[]
        ];

        return $menus;
    }


    static function pusat(){

        $menus=[
            'side_left'=>[
                'PEMETAAN PUSAT',
                [
                    'text'=>'KEBIJAKAN PUSAT',
                    'href'=>route('sink.pusat.kebijakan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y') ]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'SDGS',
                    'href'=>route('sink.pusat.sdgs.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'SPM',
                    'href'=>route('sink.pusat.kebijakan5.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'KEBIJAKAN PUSAT 5 TAHUN',
                    'href'=>route('sink.pusat.kebijakan5.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'KEBIJAKAN PUSAT 1 TAHUN',
                    'href'=>route('sink.pusat.kebijakan1.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    
                    'class'=>'',
                    'icon'=>null
                ],
                  [
                    'text'=>'MASTER INDIKATOR',
                    'href'=>route('sink.pusat.indikator.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    
                    'text'=>'KEBIJAKAN DAERAH',
                  'href'=>route('sink.pusat.kebijakandaerah.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'PERMASALAHAN DAERAH',
                    'href'=>route('sink.pusat.permasalahan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'RKPD',
                    'href'=>route('sink.pusat.rkpd.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'REKOMENDASI RKPD',
                    'href'=>route('sink.pusat.rkpd.rekomendasi.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'SCHEDULE DESK',
                    'href'=>route('sink.pusat.schedule-desk.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y')]),
                    
                    'class'=>'',
                    'icon'=>null
                ],
                // [
                //     'text'=>'STATUS FORM',
                //     'href'=>'',
                //     'class'=>'',
                //     'icon'=>null
                // ],
                // [
                //     'text'=>'USERS',
                //     'href'=>'',
                //     'class'=>'',
                //     'icon'=>null

                // ]
            ],
            'side_right'=>[],
            'top'=>[
               

            ],
        ];

        return $menus;

    }

     static function daerah(){

        $menus=[
            'side_left'=>[
                'PEMETAAN DAERAH',
                [
                    'text'=>'RKPD',
                    'href'=>route('sink.daerah.rkpd.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'kodepemda'=>(isset($GLOBALS['pemda_access']))?$GLOBALS['pemda_access']->id:999,'menu_context'=>'D' ]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'KEBIJAKAN DAERAH',
                    'href'=>route('sink.daerah.kebijakan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'kodepemda'=>(isset($GLOBALS['pemda_access']))?$GLOBALS['pemda_access']->id:999,'menu_context'=>'D' ]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'PERMASALHAN PEMDA',
                    'href'=>route('sink.daerah.permasalahan.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'kodepemda'=>(isset($GLOBALS['pemda_access']))?$GLOBALS['pemda_access']->id:999,'menu_context'=>'D' ]),
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'MASTER INDIKATOR',
                    'href'=>route('sink.daerah.indikator.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'kodepemda'=>(isset($GLOBALS['pemda_access']))?$GLOBALS['pemda_access']->id:999,'menu_context'=>'D']),
                    'class'=>'',
                    'icon'=>null
                ],
                  [
                    'text'=>'REKOMENDASI',
                    'href'=>route('sink.daerah.rekomendasi.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'kodepemda'=>(isset($GLOBALS['pemda_access']))?$GLOBALS['pemda_access']->id:999,'menu_context'=>'D'])
                    ,
                    'class'=>'',
                    'icon'=>null
                ],
                [
                    'text'=>'SCHEDULE DESK',
                    'href'=>route('sink.daerah.schedule-desk.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'kodepemda'=>(isset($GLOBALS['pemda_access']))?$GLOBALS['pemda_access']->id:999,'menu_context'=>'D']),
                    
                    'class'=>'',
                    'icon'=>null
                ],
            ],
            'side_right'=>[],
            'top'=>[
               

            ],
        ];

        return $menus;

    }
}
