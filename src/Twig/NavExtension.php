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
            'user'=>
            [
                [
                    'name'=>'Attente',
                    'path'=>'admin_attente_index',
                ]
            ],
            'admin'=>
            [
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
                
            ],
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
                    'name'=>'Mes annonces',
                    'path'=>'annonceur_index',
                    'links'=>[
                        [
                            'name'=>'New Annonce',
                            'path'=>'annonceur_new'
                        ]
                    ]
                ]
            ]
        ];
    }
}