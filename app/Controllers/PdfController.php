<?php
namespace App\Controllers;

use App\Models\{Productor,Inspeccion,Fundo,Valor,Item};
use Mpdf\Mpdf;
use Respect\Validation\Validator as v;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class   PdfController extends BaseController {

    public function getPdfInspeccion(ServerRequest $request)
    {
        $inspeccion = Inspeccion::find($request->getAttribute('idinspeccion'));
        $productor = Productor::find($inspeccion->productor_id);
        $fundo = Fundo::where('productor_id','=',$productor->productor_id)->first();
        $valores = Valor::where('inspeccion_id','=',$inspeccion->inspeccion_id)->get();

        $encuestas = [
            'sistema_de_gestion_documentario' => [
                'titulo' => 'SISTEMA DE GESTION DOCUMENTARIO',
                'numero' => '4',
                'items' => [ 
                    [
                        'numero' => '4.1',
                        'accion' => '¿tiene su reglamento interno, conoce y aplica?',
                        'criterio' => 'TODOS'
                    ],
                    [
                        'numero' => '4.2',
                        'accion' => '¿Tiene copia de su contrato de cumplimiento compromiso con norma (carta de compromiso) y reglamento interno?',
                        'criterio' => 'TODOS'
                    ],
                    [
                        'numero' => '4.3',
                        'accion' => '¿Recibe las capacitaciones del sistema interno de control, ECAs? A cuales asistio',
                        'criterio' => 'RAS'
                    ],
                    [
                        'numero' => '4.4',
                        'accion' => 'Ha elaborado su diseño predial y croquis identificando parcelas de cultivo, viveros, colindantes (tipo de cultivo), areas de amortiguamiento. proteccion, riesgo de erosion, cuerpos de agua, vivienda etc.',
                        'criterio' => 'TODOS'
                    ],
                    [
                        'numero' => '4.5',
                        'accion' => 'tiene su plan de manejo de cultivo y su cuaderno de registros actualizados',
                        'criterio' => 'TODOS'
                    ],
                    [
                        'numero' => '4.6',
                        'accion' => '¿se registra el volumen de agua utilizada en el beneficiado del producto planta de beneficio Humedo (PBH)?',
                        'criterio' => 'Cafe Practices, FLO'
                    ],
                    [
                        'numero' => '4.7',
                        'accion' => '¿tiene documentacion de sustente la entrega o venta del cafe permite identificar el volumen de cafe cosechado?',
                        'criterio' => 'TODOS'
                    ],
                    [
                        'numero' => '4.8',
                        'accion' => '¿tiene su inventario de flora y fauna?',
                        'criterio' => 'TODOS'
                    ]
                ]
            ],
            'bienestar_socia_y_laboral' => [
                'titulo' => 'BIENESTAR SOCIAL Y LABORAL',
                'numero' => '5',
                'items' => [
                    [
                        'numero' => '5.1',
                        'accion' => '¿Se aprecia orden e higiene en la finca?',
                        'criterio' => 'RAS,fLO'
                    ],
                    [
                        'numero' => '5.2',
                        'accion' => '¿Tiene baño o letrinas y estan en buen estado?',
                        'criterio' => 'UTZ FLO'
                    ],
                    [
                        'numero' => '5.3',
                        'accion' => '¿Tiene agua apta para el consumo y es accesible?',
                        'criterio' => 'FLO'
                    ],
                    [
                        'numero' => '5.4',
                        'accion' => '¿Se capacita y se prepara a los trabajadores para realizar sus labores de manera segura?',
                        'criterio' => 'FLO,RAS'
                    ],
                    [
                        'numero' => '5.5',
                        'accion' => '¿Tiene acceso a servicios de Atencion a su Salud y educacion?',
                        'criterio' => 'FLO,RAS'
                    ],
                    [
                        'numero' => '5.6',
                        'accion' => '¿Trabaja no se pone en riesgo el desaroolo, salud y educacion de menores de 18 años, No contrata a menores de 15 años?',
                        'criterio' => 'FLO,RAS'
                    ]
                ]
                    ],
            'conservacion_de_ecosistemas' => [
                'titulo' => 'CONSERVACION DE ECOSISTEMAS, AGUA, SULEO Y VIDA SILVESTRE',
                'numero' => '6',
                'items' => [
                    [
                        'numero' => '6.1',
                        'accion' => '¿Se instalan especies leguminosas de arboles de sombra y sean compatibles con el cafe?',
                        'criterio' => 'TODOS'
                    ],
                    [
                        'numero' => '6.2',
                        'accion' => 'Todas las parcelas de cafe tienes sombre? Y en que %? Es adecuado? Y que especie?',
                        'criterio' => 'UTZ FLO'
                    ]
                ]
            ]
        ];

        $html = $this->getHTML('/pdf/inspeccion.twig',[
            'inspeccion' => $inspeccion,
            'productor' => $productor,
            'fundo' => $fundo,
            'valores' => $valores,
            'encuestas' => $encuestas
        ]);

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        die();
    }

    public function getPdfFundo(ServerRequest $request)
    {

        $html = $this->getHTML('/pdf/fundo.twig',[

        ]);

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        die();
    }
}