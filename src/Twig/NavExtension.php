<?php 
namespace App\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavExtension extends AbstractExtension
{
    const icon ='far fa-circle';
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function getFunctions():array
    {
        return[
            new TwigFunction('sidebar',[$this,'getNavs'])
        ];
    }

    public function getNavs()
    {
        return 
        [
            'dashboard'=>
            [
                [
                    'name'=>$this->translator->trans('Dashboard'),
                    'icon'=>'fas fa-tachometer-alt',
                    'links'=>[
                        [
                            'name'=>$this->translator->trans('Dashboard').' 1',
                            'path'=>'admin'
                        ]
                    ]
                ],
                [
                    'name'=>'Profil',
                    'path'=>'profile_index',
                ],
                [
                    'name'=>'Gaboma annonce',
                    'icon'=>'fas fa-home',
                    'links'=>[
                        [
                            'name'=>'Home',
                            'path'=>'home'
                        ],
                        [
                            'name'=>'Annonces',
                            'path'=>'annonces'
                        ]
                    ]
                ],
                [
                    'name'=>'Annonce',
                    'icon'=>'fa fa-bullhorn',
                    'links'=>[
                        [
                            'name'=>'Mes annonces',
                            'path'=>'annonceur_index'
                        ],
                        [
                            'name'=>'New Annonce',
                            'path'=>'annonceur_new'
                        ]
                    ]
                ]
            ],
            'user'=>
            [
            ],
            'admin'=>
            [
                [
                    'name'=>'Attente',
                    'path'=>'admin_attente_index',
                ],
                [
                    'name'=>'Annonce',
                    'links'=>[
                        [
                            'name'=>'Annonces',
                            'path'=>'annonce_index',
                        ],
                        [
                            'name'=>$this->translator->trans('New'),
                            'path'=>'annonce_new',
                        ],
                    ]
                ],
                [
                    'name'=>$this->translator->trans('Category'),
                    'links'=>[
                        [
                            'name'=>'Categorys',
                            'path'=>'category_index',
                        ],
                        [
                            'name'=>'New',
                            'path'=>'category_new',
                        ],
                    ]
                ],
                [
                    'name'=>'user',
                    'icon'=>'fas fa-users',
                    'links'=>[
                        [
                            'name'=>'Users',
                            'path'=>'user_index'
                        ],
                        [
                            'name'=>'New',
                            'path'=>'user_new',
                        ]
                    ]
                ],
                
            ]
        ];
    }
}