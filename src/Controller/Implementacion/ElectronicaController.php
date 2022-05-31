<?php

namespace App\Controller\Implementacion;

use App\Entity\Cliente;
use App\Utilidades\Mensajes;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ElectronicaController extends AbstractController
{

    /**
     * @Route("/implementacion/electronica/lista", name="implementacion_electronica_lista")
     */
    public function lista(Request $request,  PaginatorInterface $paginator) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->get('OpEnviar')) {
                $codigo = $request->request->get('OpEnviar');
                $arCliente = $em->getRepository(Cliente::class)->find($codigo);
                $referencia = null;
                if($arCliente->getSuscriptor()) {
                    for ($i = 20000; $i <= 20010; $i++) {
                        $arrSoftwareEstrategico = $this->arregloDocumento($arCliente->getSuscriptor(), 'SETT', $i, '01', '05', $referencia);
                        $respuesta = $this->enviarDocumento($arrSoftwareEstrategico);
                        $referencia = $respuesta['id'];
                    }
                    for ($i = 10000; $i <= 10000; $i++) {
                        $arrSoftwareEstrategico = $this->arregloDocumento($arCliente->getSuscriptor(), 'NC', $i, '91', '22', null);
                        $respuesta = $this->enviarDocumento($arrSoftwareEstrategico);
                    }
                    for ($i = 10000; $i <= 10000; $i++) {
                        $arrSoftwareEstrategico = $this->arregloDocumento($arCliente->getSuscriptor(), 'ND', $i, '92', '32', null);
                        $respuesta = $this->enviarDocumento($arrSoftwareEstrategico);
                    }
                } else {
                    Mensajes::error('El cliente no tiene codigo de suscriptor');
                }
            }
            if ($request->request->get('OpEnviarNomina')) {
                $codigo = $request->request->get('OpEnviarNomina');
                $arCliente = $em->getRepository(Cliente::class)->find($codigo);
                $referencia = null;
                if($arCliente->getEmpleador()) {
                    $consecutivo = 1;
                    for ($i = $consecutivo; $i <= $consecutivo + 10; $i++) {
                        $arrSoftwareEstrategico = $this->arregloNomina($arCliente->getEmpleador(), $i, "NE", "102");
                        $respuesta = $this->enviarDocumentoNomina($arrSoftwareEstrategico);
                        $documento = $respuesta['documento'];
                        if($documento) {
                            $respuesta = $this->enviarDocumentoNominaAjuste($documento, $i, "NA");
                        }
                    }
                } else {
                    Mensajes::error('El cliente no tiene codigo de empleador');
                }
            }
        }
        $arrSuscriptores = $this->listaSuscriptores();
        $arClientes = $paginator->paginate($em->getRepository(Cliente::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Implementacion/Electronica/lista.html.twig', [
            'arrSuscriptores' => $arrSuscriptores,
            'arClientes' => $arClientes,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/implementacion/electronica/nuevo/{id}", name="implementacion_electronica_nuevo")
     */
    public function nuevo(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $arrBtnHabilitar = ['label' => 'Guardar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $form = $this->createFormBuilder()
            ->add('Documento', TextType::class, ['data' => ""])
            ->add('Dv', TextType::class, ['data' => ""])
            ->add('RazonSocial', TextType::class, ['data' => ""])
            ->add('Nombres', TextType::class, ['data' => ''])
            ->add('Apellidos', TextType::class, ['data' => ''])
            ->add('Direccion', TextType::class, ['data' => ""])
            ->add('CodigoPostal', TextType::class, ['data' => ""])
            ->add('CodigoCiudad', TextType::class, ['data' => "", 'disabled' => true])
            ->add('NombreCiudad', TextType::class, ['data' => "", 'disabled' => true])
            ->add('CodigoDepartamento', TextType::class, ['data' => "", 'disabled' => true])
            ->add('NombreDepartamento', TextType::class, ['data' => "", 'disabled' => true])
            ->add('Obligaciones', TextType::class, ['data' => ""])
            ->add('Correo', TextType::class, ['data' => ""])
            ->add('Telefono', TextType::class, ['data' => ""])
            ->add('Certificadopropio', TextType::class, ['data' => "", 'disabled' => true])
            ->add('SerialCertificado', TextType::class, ['data' => "", 'disabled' => true])
            ->add('pinCertificado', TextType::class, ['data' => "", 'disabled' => true])
            ->add('CodigoPersona', TextType::class, ['data' => "", 'required' => true])
            ->add('TipoPersona', TextType::class, ['data' => "", 'disabled' => true])
            ->add('CodigoRegimen', TextType::class, ['data' => ""])
            ->add('NombreRegimen', TextType::class, ['data' => "", 'disabled' => true])
            ->add('Sosftware', TextType::class, ['data' => "", 'disabled' => true])
            ->add('Proveedor', TextType::class, ['data' => "", 'disabled' => true])
            ->add('DvProveedor', TextType::class, ['data' => "", 'disabled' => true])
            ->add('TestPruebas', TextType::class, ['data' => ""])
            ->add('CorreoDian', TextType::class, ['data' => "", 'disabled' => true])
            ->add('RegistroHabilitacion', TextType::class, ['data' => "", 'disabled' => true])
            ->add('DocumentoAliado', TextType::class, ['data' => "", 'disabled' => true])
            ->add('NombreAliado', TextType::class, ['data' => "", 'disabled' => true])
            ->add('btnHabilitar', SubmitType::class, $arrBtnHabilitar)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnHabilitar')->isClicked()) {
                $arrDatos = [
                    "SuscDocumento" => $form->get("Documento")->getData(),
                    "SuscDv" => $form->get("Dv")->getData(),
                    "EnviarSetPruebas" => false,
                    "SuscRazonSocial" => $form->get("RazonSocial")->getData(),
                    "SuscDireccion" => $form->get("Direccion")->getData(),
                    "SuscObligaciones" => $form->get("Obligaciones")->getData(),
                    "SuscNombres" => "1",
                    "SuscApellidos" => "1",
                    "SuscCorreo" => $form->get("Correo")->getData(),
                    "SuscTelefono" => $form->get("Telefono")->getData(),
                    "TipoPersona" => $form->get("CodigoPersona")->getData(),
                    "Regimen" => $form->get("CodigoRegimen")->getData(),
                    "CodigoPostal" => $form->get("CodigoPostal")->getData(),
                    "NitAliado" => "901192048",
                    "SushTestSetId" => $form->get("TestPruebas")->getData(),
                ];
                $this->habilitarSuscriptor($arrDatos);
            }
        }

        return $this->render('Implementacion/Electronica/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/implementacion/electronica/editar/{id}", name="implementacion_electronica_editar")
     */
    public function editar(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $arrRespuesta = $this->consultarSuscriptor($id);
        $arrSuscriptor = $arrRespuesta['Suscriptor'];
        $arrResoluciones = $arrRespuesta['ResolucionesFacturas']['ResolucionesFacturacion'];

        $arrBtnHabilitar = ['label' => 'Guardar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $form = $this->createFormBuilder()
            ->add('Documento', TextType::class, ['data' => $arrSuscriptor['Documento']])
            ->add('Dv', TextType::class, ['data' => $arrSuscriptor['Dv']])
            ->add('RazonSocial', TextType::class, ['data' => $arrSuscriptor['RazonSocial']])
            ->add('Nombres', TextType::class, ['data' => ''])
            ->add('Apellidos', TextType::class, ['data' => ''])
            ->add('Direccion', TextType::class, ['data' => $arrSuscriptor['Direccion']])
            ->add('CodigoPostal', TextType::class, ['data' => $arrSuscriptor['CodigoPostal']])
            ->add('CodigoCiudad', TextType::class, ['data' => $arrSuscriptor['CodigoCiudad'], 'disabled' => true])
            ->add('NombreCiudad', TextType::class, ['data' => $arrSuscriptor['NombreCiudad'], 'disabled' => true])
            ->add('CodigoDepartamento', TextType::class, ['data' => $arrSuscriptor['CodigoDepartamento'], 'disabled' => true])
            ->add('NombreDepartamento', TextType::class, ['data' => $arrSuscriptor['NombreDepartamento'], 'disabled' => true])
            ->add('Obligaciones', TextType::class, ['data' => $arrSuscriptor['Obligaciones']])
            ->add('Correo', TextType::class, ['data' => $arrSuscriptor['Correo']])
            ->add('Telefono', TextType::class, ['data' => $arrSuscriptor['Telefono']])
            ->add('Certificadopropio', TextType::class, ['data' => $arrSuscriptor['Certificadopropio'], 'disabled' => true])
            ->add('SerialCertificado', TextType::class, ['data' => $arrSuscriptor['SerialCertificado'], 'disabled' => true])
            ->add('pinCertificado', TextType::class, ['data' => $arrSuscriptor['pinCertificado'], 'disabled' => true])
            ->add('CodigoPersona', TextType::class, ['data' => $arrSuscriptor['CodigoPersona'], 'required' => true])
            ->add('TipoPersona', TextType::class, ['data' => $arrSuscriptor['TipoPersona'], 'disabled' => true])
            ->add('CodigoRegimen', TextType::class, ['data' => $arrSuscriptor['CodigoRegimen']])
            ->add('NombreRegimen', TextType::class, ['data' => $arrSuscriptor['NombreRegimen'], 'disabled' => true])
            ->add('Sosftware', TextType::class, ['data' => $arrSuscriptor['Sosftware'], 'disabled' => true])
            ->add('Proveedor', TextType::class, ['data' => $arrSuscriptor['Proveedor'], 'disabled' => true])
            ->add('DvProveedor', TextType::class, ['data' => $arrSuscriptor['DvProveedor'], 'disabled' => true])
            ->add('TestPruebas', TextType::class, ['data' => $arrSuscriptor['TestPruebas']])
            ->add('CorreoDian', TextType::class, ['data' => $arrSuscriptor['CorreoDian'], 'disabled' => true])
            ->add('RegistroHabilitacion', TextType::class, ['data' => $arrSuscriptor['RegistroHabilitacion'], 'disabled' => true])
            ->add('DocumentoAliado', TextType::class, ['data' => $arrSuscriptor['DocumentoAliado'], 'disabled' => true])
            ->add('NombreAliado', TextType::class, ['data' => $arrSuscriptor['NombreAliado'], 'disabled' => true])
            ->add('btnHabilitar', SubmitType::class, $arrBtnHabilitar)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnHabilitar')->isClicked()) {
                $arrDatos = [
                    "SuscDocumento" => $form->get("Documento")->getData(),
                    "SuscDv" => $form->get("Dv")->getData(),
                    "EnviarSetPruebas" => false,
                    "SuscRazonSocial" => $form->get("RazonSocial")->getData(),
                    "SuscDireccion" => $form->get("Direccion")->getData(),
                    "SuscObligaciones" => $form->get("Obligaciones")->getData(),
                    "SuscNombres" => "1",
                    "SuscApellidos" => "1",
                    "SuscCorreo" => $form->get("Correo")->getData(),
                    "SuscTelefono" => $form->get("Telefono")->getData(),
                    "TipoPersona" => $form->get("CodigoPersona")->getData(),
                    "Regimen" => $form->get("CodigoRegimen")->getData(),
                    "CodigoPostal" => $form->get("CodigoPostal")->getData(),
                    "NitAliado" => "901192048",
                    "SushTestSetId" => $form->get("TestPruebas")->getData(),
                ];
                $this->habilitarSuscriptor($arrDatos);
            }
        }

        return $this->render('Implementacion/Electronica/editar.html.twig', [
            'arrResoluciones' => $arrResoluciones,
            'form' => $form->createView()
        ]);
    }

    public function listaSuscriptores() {
        $url = "https://tufactura.co/habilitacion/api/ConValidacionPrevia/SuscriptoresAliado/A7AF0233-946E-42CA-A42F-7B6574B9A8D8";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "900395252:tufactura.co@softwareestrategico.com");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            )
        );

        $resp = json_decode(curl_exec($ch), true);
        return $resp;
    }

    public function consultarSuscriptor($suscriptor) {
        $url = "https://tufactura.co/habilitacion/api/ConValidacionPrevia/ResumenSuscriptor/{$suscriptor}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "900395252:tufactura.co@softwareestrategico.com");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            )
        );

        $resp = json_decode(curl_exec($ch), true);
        return $resp;
    }

    public function habilitarSuscriptor($arrDatos) {
        $url = "https://tufactura.co/habilitacion/api/ConValidacionPrevia/HabilitarFacturador";
        $data_string = json_encode($arrDatos);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "900395252:tufactura.co@softwareestrategico.com");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' .strlen($data_string))
        );
        $resp = json_decode(curl_exec($ch), true);
        curl_close($ch);

    }

    public function arregloDocumento($suscriptor, $prefijo, $numero, $tipo, $tipoCodigo, $referencia) {

        $numeroCompleto = $prefijo.$numero;
        $fecha = new \DateTime('now');
        $arrImpuestos[] = [
            "DediBase" => "1260504.00",
            "DediValor" => "239495.76",
            "DediFactor" => "19.00",
            "UnimCodigo" => "1",
        ];

        $arrDatos = [
            "Solicitud" => [
                "Nonce" => "af4c65a3-0a18-4b09-8ca7-475c95b45894",
                "Suscriptor" => $suscriptor
            ],
            "FacturaVenta" => [
                "Cabecera" => [
                    "DoceManejaPeriodos" => 0,
                    "DoceConsecutivo" => $numeroCompleto,
                    "DoceCantidadItems" => 1,
                    "AmbdCodigo" => 2,
                    "TipoCodigo" => $tipoCodigo,
                    "DoetCodigo" => $tipo,
                    "MoneCodigo" => "COP",
                    "RefvNumero" => "18760000001"
                ],
                "PagosFactura" => [
                    "ForpCodigo" => 2,
                    "DoepFechaVencimiento" => $fecha->format('Y-m-d') . 'T12:00:00',
                    "Medios" => [
                        [
                            "DempCodigo" => "31",
                            "DempDescripcion" => " "
                        ]
                    ]
                ],
                "Observaciones" => [],
                "Referencias" => [],
                "AdquirienteFactura" => [
                    "DoeaEsResponsable" => 1,
                    "DoeaEsnacional" => 1,
                    "TidtCodigo" => '31',
                    "DoeaDocumento" => '901192048',
                    "DoeaDiv" => '4',
                    "DoeaRazonSocial" => 'Semantica Digital S.A.S',
                    "DoeaNombreCiudad" => 'MEDELLIN',
                    "DoeaNombreDepartamento" => 'ANTIOQUIA',
                    "DoeaPais" => "CO",
                    "DoeaDireccion" => 'Calle 34 Nro. 66A - 33 Oficina 201',
                    "DoeaObligaciones" => "O-99",
                    "DoeaNombres" => "",
                    "DoeaApellidos" => "",
                    "DoeaOtrosNombres" => "",
                    "DoeaCorreo" => 'investigacion@semantica.com.co',
                    "DoeaTelefono" => '5578945',
                    "TiotCodigo" => '1',
                    "RegCodigo" => '05',
                    "CopcCodigo" => '050001',
                    "DoeaManejoAdjuntos" => 1
                ],
                "ImpuestosFactura" => [
                    [
                        "DoeiTotal" => "239495.76",
                        "DoeiEsPorcentual" => 1,
                        "ImpuCodigo" => "01",
                        "Detalle" =>  $arrImpuestos
                    ]
                ],
                "PeriodoFactura" => [
                    "DoepFechaInicial" => $fecha->format('Y-m-d') . 'T12:00:00',
                    "DoepFechaFinal" => $fecha->format('Y-m-d') . 'T12:00:00'
                ],
                "ResumenImpuestosFactura" => [
                    "DeriTotalIva" => "239495.76",
                    "DeriTotalConsumo" => 0,
                    "DeriTotalIca" => 0
                ],
                "TotalesFactura" => [
                    "DoetSubtotal" => "1260504.00",
                    "DoetBase" => "1260504.00",
                    "DoetTotalImpuestos" => "239495.76",
                    "DoetSubtotalMasImpuestos" => "1499999.76",
                    "DoetTotalDescuentos" => 0,
                    "DoetTotalcargos" => 0,
                    "DoetTotalAnticipos" => 0,
                    "DoetTotalDocumento" => "1499999.76"
                ]
            ]
        ];
        $arrDatos['FacturaVenta']['DetalleFactura'][] =
            [
                "DoeiItem" => "1",
                "DoeiCodigo" => "1",
                "DoeiDescripcion" => "ARRENDAMIENTOS BIEN INMUE GRAV",
                "DoeiMarca" => "",
                "DoeiModelo" => "",
                "DoeiObservacion" => "",
                "DoeiDatosVendedor" => "",
                "DoeiCantidad" => "1.00",
                "DoeiCantidadEmpaque" => "1.00",
                "DoeiEsObsequio" => 0,
                "DoeiPrecioUnitario" => "1260504.00",
                "DoeiPrecioReferencia" => "1260504.00",
                "DoeiValor" => "1260504.00",
                "DoeiTotalDescuentos" => 0,
                "DoeiTotalCargos" => 0,
                "DoeiTotalImpuestos" => "239495.76",
                "DoeiBase" => "1260504.00",
                "DoeiSubtotal" => "1260504.00",
                "TicpCodigo" => "999",
                "UnimCodigo" => "94",
                "CtprCodigo" => "02",
                "ImpuestosLinea" => [
                    [
                        "DoeiTotal" => "239495.76",
                        "DoeiEsPorcentual" => 1,
                        "ImpuCodigo" => "01",
                        "Detalle" => [
                            [
                                "DediBase" => "1260504.00",
                                "DediValor" => "239495.76",
                                "DediFactor" => "19.00",
                                "UnimCodigo" => "1"
                            ]
                        ]
                    ]
                ],
                "ImpuestosRetenidosLinea" => [],
                "CargosDescuentosLinea" => []
            ];

        if ($tipo == '91' || $tipo == '92') {
            if($referencia) {
                $arrDatos['FacturaVenta']['DocumentoReferencia'] = [
                    "DedrDocumentoReferencia" => $referencia,
                    "CodigoConcepto" => "2"
                ];
            } else {
                $arrDatos['FacturaVenta']['DocumentoReferencia'] = [
                    "DedrDocumentoReferencia" => null,
                    "DedrFecha"=> null,
                    "CodigoConcepto" => "4"
                ];
            }
        }

        return $arrDatos;
    }

    public function enviarDocumento($arrSoftwareEstrategico) {
        $url = "https://tufactura.co/habilitacion/api/ConValidacionPrevia/CrearSetPrueba";
        $json = json_encode($arrSoftwareEstrategico);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "900395252:tufactura.co@softwareestrategico.com");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            )
        );
        $resp = json_decode(curl_exec($ch), true);
        $doceId = null;
        $resultado = false;
        if ($resp) {
            if (isset($resp['Validaciones'])) {
                $validaciones = $resp['Validaciones'];
                if ($validaciones['Valido']) {
                    $doceId = $validaciones['DoceId'];
                    $resultado = true;
                }
            }
        }
        return ['resultado' => $resultado, 'id' => $doceId, 'respuesta' => $resp];
    }

    public function enviarDocumentoNomina($arrSoftwareEstrategico) {
        $url = "https://apps.kiai.co/api/NominaElectronica/Emitir";
        $json = json_encode($arrSoftwareEstrategico);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "900395252:tufactura.co@softwareestrategico.com");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            )
        );
        $resp = json_decode(curl_exec($ch), true);
        $doceId = null;
        $documento = null;
        $resultado = false;
        if ($resp) {
            if (isset($resp['Validaciones'])) {
                $validaciones = $resp['Validaciones'];
                if ($validaciones['Valido']) {
                    $doceId = $validaciones['DoceId'];
                    $documento = $validaciones['Documento'];
                    $resultado = true;
                }
            }
        }
        return ['resultado' => $resultado, 'id' => $doceId, 'documento' => $documento, 'respuesta' => $resp];
    }

    public function enviarDocumentoNominaAjuste($Cune, $consecutivo, $prefijo) {
        $url = "https://apps.kiai.co/api/NominaElectronica/EliminarNota/{$Cune}/{$consecutivo}/$prefijo";
        $json = json_encode([]);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "900395252:tufactura.co@softwareestrategico.com");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            )
        );
        $resp = json_decode(curl_exec($ch), true);
        return $resp;
    }

    public function arregloNomina($empleador, $consecutivo, $prefijo, $documento) {
        $arrResultado = [
            "Solicitud" => [
                "Nonce" => "23da5874-01e0-4c5a-85bf-18bcb7bf29fe",
                "Empleador" => $empleador
            ],
            "Nomina" => [
                "Novedad" => [
                    "CUNENov" => null,
                    "Estado" => false
                ],
                "Periodos" => [
                    "FechaIngreso" => "2022-01-01T00:00:00",
                    "FechaRetiro" => "0001-01-01T00:00:00",
                    "FechaLiquidacionInicio" => "2022-01-01T00:00:00",
                    "FechaLiquidacionFin" => "2022-01-31T00:00:00",
                    "TiempoLaborado" => 1
                ],
                "NumeroSecuenciaXML" => [
                    "CodigoTrabajador" => "1",
                    "Prefijo" => "{$prefijo}",
                    "Consecutivo" => $consecutivo,
                    "Numero" => "{$prefijo}{$consecutivo}"
                ],
                "ProveedorXML" => [
                    "SoftwareID" => "7ad11bac-3d34-46e2-8376-f878996a4b5b"
                ],
                "InformacionGeneral" => [
                    "Ambiente" => 2,
                    "TipoXML" => $documento,
                    "PeriodoNomina" => "4",
                    "TipoMoneda" => "COP",
                    "Notas" => null,
                    "TRM" => 0

                ],
                "Trabajador" => [
                    "TipoTrabajador" => "01",
                    "SubTipoTrabajado" => "00",
                    "AltoRiesgoPensio" => false,
                    "TipoDocumento" => "13",
                    "NumeroDocumento" => "71145748",
                    "PrimerApellido" => "PEREZ",
                    "SegundoApellido" => "CAMARGO",
                    "PrimerNombre" => "JUAN",
                    "OtrosNombres" => "EMILIO",
                    "LugarTrabajoPais" => "CO",
                    "LugarTrabajoDepartamentoEstado" => "05",
                    "LugarTrabajoMunicipioCiudad" => "05001",
                    "LugarTrabajoDireccion" => "CALLE 48A N 100A-34",
                    "SalarioIntegral" => false,
                    "TipoContrato" => "2",
                    "Sueldo" => 1100000,
                    "CodigoTrabajador" => 1
                ],
                "Pago" => [
                    "Forma" => "1",
                    "Metodo" => "42",
                    "Banco" => "BANCOLOMBIA",
                    "TipoCuenta" => "H",
                    "NumeroCuenta" => "51189783519"
                ],
                "FechasPagos" => [
                    "2022-01-31T00:00:00",
                    "2022-01-31T00:00:00"
                ],
                "Devengados" => [
                    "Basico" => [
                        'DiasTrabajados' => 30,
                        'SueldoTrabajado' => 1100000
                    ],
                    "Transporte" => [
                        "AuxilioTransporte" => 106454,
                        "ViaticoManuAlojS" => 0,
                        "ViaticoManuAlojNS" => 0
                    ],
                    "HorasExtras" => [
                        "HED" => [
                        ],
                        "HEN" => [
                        ],
                        "HRN" => [
                        ],
                        "HEDDF" => [
                        ],
                        "HRDDF" => [
                        ],
                        "HENDF" => [
                        ],
                        "HRNDF" => [
                        ],
                    ],
                    "Vacaciones" => [
                        "VacacionesComunes" => [
                        ],
                        "VacacionesCompensadas" => [
                        ]
                    ],
                    "Primas" => [
                        "Cantidad" => 0,
                        "Pago" => 0,
                        "PagoNS" => 0
                    ],
                    "Cesantias" => [
                        "Pago" => 0,
                        "Porcentaje" => 0,
                        "PagoIntereses" => 0
                    ],
                    "Incapacidades" => [
                    ],
                    "Licencias" => [
                        "LicenciaMP" => [
                        ],
                        "LicenciaR" => [
                        ],
                        "LicenciaNR" => [
                        ],
                    ],
                    "Bonificaciones" => [
                        "BonificacionNS" => 0,
                        "BonificacionS" => 0
                    ],
                    "Auxilios" => [
                        "AuxilioNS" => 0,
                        "AuxilioS" => 0
                    ],
                    "HuelgasLegales" => [
                    ],
                    "OtrosConceptos" => [
                    ],
                    "Compensaciones" => [
                    ],
                    "BonoEPCTVs" => [
                    ],
                    "Comisiones" => [
                    ],
                    "PagosTerceros" => [
                    ],
                    "Anticipos" => [
                    ],
                    "Dotacion" => 0,
                    "ApoyoSost" => 0,
                    "Teletrabajo" => 0,
                    "BonifRetiro" => 0,
                    "Indemnizacion" => 0,
                    "Reintegro" => 0
                ],
                "Deducciones" => [
                    "Salud" => [
                        "Porcentaje" => 4,
                        "Deduccion" => 44000
                    ],
                    "FondoPension" => [
                        "Porcentaje" => 4,
                        "Deduccion" => 44000
                    ],
                    "FondoSP" => [
                        "Porcentaje" => 0,
                        "DeduccionSP" => 0,
                        "PorcentajeSub" => 0,
                        "DeduccionSub" => 0
                    ],
                    "Sindicatos" => [
                    ],
                    "Sanciones" => [
                    ],
                    "Libranzas" => [
                    ],
                    "PagosTerceros" => [
                    ],
                    "Anticipos" => [
                    ],
                    "OtrasDeducciones" => [
                    ],
                    "PensionVoluntaria" => 0,
                    "RetencionFuente" => 0,
                    "AFC" => 0,
                    "Cooperativa" => 0,
                    "EmbargoFiscal" => 0,
                    "PlanComplementarios" => 0,
                    "Educacion" => 0,
                    "Reintegro" => 0,
                    "Deuda" => 0
                ],
                "Redondeo" => 0,
                "DevengadosTotal" => 1206454,
                "DeduccionesTotal" => 88000,
                "ComprobanteTotal" => 1118454
            ]
        ];
        return $arrResultado;
    }


}
