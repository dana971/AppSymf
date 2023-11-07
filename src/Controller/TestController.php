<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


class TestController extends AbstractController
{
    #[Route('/test', name: 'test',methods: ['GET', 'HEAD'] )]
    public function index(Request $request): Response
    {
        return $this->render('test/index.html.twig');
    }

    #[Route('/hello/{age}/{nom}/{prenom}', name: 'hello',
        requirements: ["nom"=>"[a-z]{2,50}"])]
    public function hello(ChartBuilderInterface $chartBuilder,Request $request, int $age, $nom, $prenom='')
    {
        $chart =$chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels'    => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets'  => [[
                'label' => 'My First dataset',
                'backgroundColor' => 'rgb(255, 99, 132)',
                'borderColor' => 'rgb(255, 99, 132)',
                'data' => [0, 10, 5, 2, 20, 30, 45],
            ],
           ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y'  => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);


        $histo=$chartBuilder->createChart(Chart::TYPE_BAR);
        $histo->setData([
            'labels' => ['Rouge', 'Vert', 'Bleu', 'Jaune'],
            'datasets'=> [
                [
                    'label'=> 'Mon histogramme',
                    'data'=> [10 ,20 , 50 , 30],
                    'backgroundColor'=>['#FF0000', '#00FF00',
                        '#0000FF', '#FFFF00']
                ],
            ],
        ]);

        $histo->setOptions([
            'scales' => [
                'y'  => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('test/hello.html.twig', [
            'histo'=>$histo,
            'chart'=> $chart,
            'nom' => $nom,
            'prenom' => $prenom,
            'age' => $age,
            'messageHtml'=>'<h3>je vais tester raw</h3>',
            'monTableau'=>['profession'=>'formateur',
                           'sexe'=>'M',
                            'spécialité'=>'Symfony']
        ]);
    }
}


