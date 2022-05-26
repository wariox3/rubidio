<?php


namespace App\Controller\Api;

use App\Entity\Documentacion;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class DocumentacionController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/documentacion/lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $criterio = $raw['criterio'] ?? null;
        $modulo = $raw['modulo'] ?? null;
        $arRegistros = $em->getRepository(Documentacion::class)->apiLista($criterio, $modulo);
        return $arRegistros;
    }


    /**
     * @Rest\Post("/api/documentacion/detalle")
     */
    public function detalle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $id = $raw['id'] ?? null;
        $arRegistro = $em->getRepository(Documentacion::class)->apiDetalle($id);
        return $arRegistro;
    }

    /**
     * @Rest\Post("/api/documentacion/indice")
     */
    public function indice(Request $request)
    {
        $arrIndice['inventario'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'extranjero',
                        'item' => [
                            ['nombre' => 'importacion', 'titulo' => 'Importación', 'entidad' => 'InvImportacion', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'inventario',
                        'item' => [
                            ['nombre' => 'documento', 'titulo' => 'Entrada', 'entidad' => 'InvMovimiento', 'parametro' => 'tipodocumento', 'valor' => 'ENT', 'ayuda' => 63],
                            ['nombre' => 'documento', 'titulo' => 'Salida', 'entidad' => 'InvMovimiento', 'parametro' => 'tipodocumento', 'valor' => 'SAL', 'ayuda' => 63],
                            ['nombre' => 'documento', 'titulo' => 'Compra', 'entidad' => 'InvMovimiento', 'parametro' => 'tipodocumento', 'valor' => 'COM', 'ayuda' => 63],
                            ['nombre' => 'documento', 'titulo' => 'Factura', 'entidad' => 'InvMovimiento', 'parametro' => 'tipodocumento', 'valor' => 'FAC', 'ayuda' => 63],
                            ['nombre' => 'documento', 'titulo' => 'Nota credito', 'entidad' => 'InvMovimiento', 'parametro' => 'tipodocumento', 'valor' => 'NC', 'ayuda' => 63],
                            ['nombre' => 'documento', 'titulo' => 'Nota debito', 'entidad' => 'InvMovimiento', 'parametro' => 'tipodocumento', 'valor' => 'ND', 'ayuda' => 63],
                            ['nombre' => 'documento', 'titulo' => 'Traslado', 'entidad' => 'InvMovimiento', 'parametro' => 'tipodocumento', 'valor' => 'TRA', 'ayuda' => 1000],
                            ['nombre' => 'costo', 'titulo' => 'Costo', 'entidad' => 'InvCosto', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'compra',
                        'item' => [
                            ['nombre' => 'solicitud', 'titulo' => 'Solicitud', 'entidad' => 'InvSolicitud', 'ayuda' => 73],
                            ['nombre' => 'orden', 'titulo' => 'Orden', 'entidad' => 'InvOrden', 'ayuda' => 64],

                        ]
                    ],
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'cotizacion', 'titulo' => 'Cotización', 'entidad' => 'InvCotizacion', 'ayuda' => 51],
                            ['nombre' => 'pedido', 'titulo' => 'Pedido', 'entidad' => 'InvPedido', 'ayuda' => 66],
                            ['nombre' => 'remision', 'titulo' => 'Remisión', 'entidad' => 'InvRemision', 'ayuda' => 69],
                        ]
                    ],
                    ['nombre' => 'control',
                        'item' => [
                            ['nombre' => 'servicio', 'titulo' => 'Servicio', 'entidad' => 'InvServicio', 'ayuda' => 71],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'tercero', 'titulo' => 'Tercero', 'entidad' => 'InvTercero', 'ayuda' => 77],
                            ['nombre' => 'contacto', 'titulo' => 'Contacto', 'entidad' => 'InvContacto', 'ayuda' => 49],
                            ['nombre' => 'precio', 'titulo' => 'Precio', 'entidad' => 'InvPrecio', 'ayuda' => 68],
                            ['nombre' => 'sucursal', 'titulo' => 'Sucursal', 'entidad' => 'InvSucursal', 'ayuda' => 76],
                        ]
                    ],
                    ['nombre' => 'extranjero',
                        'item' => [
                            ['nombre' => 'importaciontipo', 'titulo' => 'Importación tipo', 'entidad' => 'InvImportacionTipo', 'ayuda' => 59],
                            ['nombre' => 'importacioncostoconcepto', 'titulo' => 'Importación costo concepto', 'entidad' => 'InvImportacionCosto', 'ayuda' => 58],

                        ]
                    ],
                    ['nombre' => 'inventario',
                        'item' => [
                            ['nombre' => 'documento', 'titulo' => 'Documento', 'entidad' => 'InvDocumento', 'ayuda' => 53],
                            ['nombre' => 'item', 'titulo' => 'Ítem', 'entidad' => 'InvItem', 'ayuda' => 60],
                            ['nombre' => 'linea', 'titulo' => 'Línea', 'entidad' => 'InvLinea', 'ayuda' => 61],
                            ['nombre' => 'grupo', 'titulo' => 'Grupo', 'entidad' => 'InvGrupo', 'ayuda' => 56],
                            ['nombre' => 'subgrupo', 'titulo' => 'Subgrupo', 'entidad' => 'InvsubGrupo', 'ayuda' => 75],
                            ['nombre' => 'marca', 'titulo' => 'Marca', 'entidad' => 'InvMarca', 'ayuda' => 62],
                            ['nombre' => 'bodega', 'titulo' => 'Bodega', 'entidad' => 'InvBodega', 'ayuda' => 47],
                            ['nombre' => 'facturatipo', 'titulo' => 'Factura tipo', 'entidad' => 'InvFacturaTipo', 'ayuda' => 55],
                            ['nombre' => 'costotipo', 'titulo' => 'Costo tipo', 'entidad' => 'InvCostoTipo', 'ayuda' => 50],
                            ['nombre' => 'bodegausuario', 'titulo' => 'Bodega usuario', 'entidad' => 'InvBodegaUsuario', 'ayuda' => 48],
                            ['nombre' => 'medida', 'titulo' => 'Medida', 'entidad' => 'InvMedida', 'ayuda' => 1000],
                            ['nombre' => 'talla', 'titulo' => 'Talla', 'entidad' => 'InvTalla', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'compras',
                        'item' => [
                            ['nombre' => 'solicitudtipo', 'titulo' => 'Solicitud tipo', 'entidad' => 'InvSolicitudTipo', 'ayuda' => 74],
                            ['nombre' => 'ordentipo', 'titulo' => 'Orden tipo', 'entidad' => 'InvOrdenTipo', 'ayuda' => 65],
                        ]
                    ],
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'pedidotipo', 'titulo' => 'Pedido tipo', 'entidad' => 'InvPedidoTipo', 'ayuda' => 67],
                            ['nombre' => 'remisiontipo', 'titulo' => 'Remisión tipo', 'entidad' => 'InvRemisionTipo', 'ayuda' => 70],
                            ['nombre' => 'cotizaciontipo', 'titulo' => 'Cotización tipo', 'entidad' => 'InvCotizacionTipo', 'ayuda' => 52],
                        ]
                    ],
                    ['nombre' => 'control',
                        'item' => [
                            ['nombre' => 'serviciotipo', 'titulo' => 'Servicio tipo', 'entidad' => 'InvServicioTipo', 'ayuda' => 72],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'proceso',
                'icono' => 'fal fa-database',
                'grupo' => [
                    ['nombre' => 'inventario',
                        'item' => [
                            ['nombre' => 'regenerar', 'titulo' => 'Regenerar', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'contabilidad',
                        'item' => [
                            ['nombre' => 'importacion', 'titulo' => 'Importación', 'entidad' => '', 'ayuda' => 57],
                            ['nombre' => 'movimiento', 'titulo' => 'Movimiento', 'entidad' => '', 'ayuda' => 63],
                        ]
                    ],
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'facturaelectronica', 'titulo' => 'Facturación electrónica', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ]

                ],
            ],
            [
                'nombre' => 'utilidad',
                'icono' => 'fal fa-bolt',
                'grupo' => [
                    ['nombre' => 'inventario',
                        'item' => [
                            ['nombre' => 'reliquidar', 'titulo' => 'Re-liquidar', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'lote',
                        'item' => [
                            ['nombre' => 'corregirfechavencimiento', 'titulo' => 'Corregir fecha vencimiento', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'corregirfactura', 'titulo' => 'Corregir factura', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]

                ],
            ],
            [
                'nombre' => 'informe',
                'icono' => 'fal fa-th-list',
                'grupo' => [
                    ['nombre' => 'item',
                        'item' => [
                            ['nombre' => 'existencia', 'titulo' => 'Existencia', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'rotacion', 'titulo' => 'Rotación', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'stockbajo', 'titulo' => 'Stock bajo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'lote',
                        'item' => [
                            ['nombre' => 'existencia', 'titulo' => 'Existencia', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'movimiento',
                        'item' => [
                            ['nombre' => 'kardex', 'titulo' => 'Kardex', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'disponible', 'titulo' => 'Disponible', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'detalle', 'titulo' => 'Detalles', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'inventariovalorizado', 'titulo' => 'Inventario valorizado', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'remision',
                        'item' => [
                            ['nombre' => 'kardex', 'titulo' => 'Kardex', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'preciodetalle', 'titulo' => 'Precio detalle', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pedidopendiente', 'titulo' => 'Pedidos pendientes', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'remisionpendiente', 'titulo' => 'Remisiones pendientes', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'remisiondetalle', 'titulo' => 'Remisiones detalles', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'ventasasesor', 'titulo' => 'Ventas por asesor', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'clientebloqueado', 'titulo' => 'Clientes bloqueados', 'entidad' => '', 'ayuda' => 1000],


                        ]
                    ],
                    ['nombre' => 'compra',
                        'item' => [
                            ['nombre' => 'solicitudpendiente', 'titulo' => 'Solicitud pendiente', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'ordenpendiente', 'titulo' => 'Orden pendiente', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'ordendetalle', 'titulo' => 'Orden detalle', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'asesor', 'titulo' => 'Venta', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'detalle', 'titulo' => 'Venta detalle', 'entidad' => '', 'ayuda' => 1000],


                        ]
                    ]
                ],
            ],
        ];
        $arrIndice['turno'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'cotizacion', 'titulo' => 'Cotización', 'entidad' => 'TurCotizacion', 'ayuda' => 204],
                            ['nombre' => 'contrato', 'titulo' => 'Contrato', 'entidad' => 'TurContrato', 'ayuda' => 201],
                        ]
                    ],
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'pedido', 'titulo' => 'Pedido', 'entidad' => 'TurPedido', 'ayuda' => 210],
                            ['nombre' => 'factura', 'titulo' => 'Factura', 'entidad' => 'TurFactura', 'ayuda' => 206],
                        ]
                    ],
                    ['nombre' => 'operacion',
                        'item' => [
                            ['nombre' => 'programacion', 'titulo' => 'Programación', 'entidad' => 'TurProgramacion', 'ayuda' => 1002],
                            ['nombre' => 'soporte', 'titulo' => 'Soporte', 'entidad' => 'TurSoporte', 'ayuda' => 214],
                            ['nombre' => 'novedad', 'titulo' => 'Novedad', 'entidad' => 'TurNovedad', 'ayuda' => 1000],
                            ['nombre' => 'analisisriesgo', 'titulo' => 'Análisis riesgo', 'entidad' => 'TurAnalisisRiesgo', 'ayuda' => 1000],
                            ['nombre' => 'incidente', 'titulo' => 'Incidente', 'entidad' => 'TurIncidente', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'financiero',
                        'item' => [
                            ['nombre' => 'cierre', 'titulo' => 'Cierre', 'entidad' => 'TurCierre', 'ayuda' => 199],
                        ]
                    ],
                ],
            ],
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'juridico',
                        'item' => [
                            ['nombre' => 'contratotipo', 'titulo' => 'Contrato tipo', 'entidad' => 'TurContratoTipo', 'ayuda' => 202],

                        ]
                    ],
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'prospecto', 'titulo' => 'Prospecto', 'entidad' => 'TurProspecto', 'ayuda' => 200],
                            ['nombre' => 'cliente', 'titulo' => 'Cliente', 'entidad' => 'TurCliente', 'ayuda' => 200],
                            ['nombre' => 'puesto', 'titulo' => 'Puesto', 'entidad' => 'TurPuesto', 'ayuda' => 212],
                            ['nombre' => 'cotizaciontipo', 'titulo' => 'Cotización tipo', 'entidad' => 'TurCotizacionTipo', 'ayuda' => 205],
                            ['nombre' => 'pedidotipo', 'titulo' => 'Pedido tipo', 'entidad' => 'TurPedidoTipo', 'ayuda' => 211],
                        ]
                    ],
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'item', 'titulo' => 'Item', 'entidad' => 'TurItem', 'ayuda' => 207],
                            ['nombre' => 'facturatipo', 'titulo' => 'Factura tipo', 'entidad' => 'TurFacturaTipo', 'ayuda' => 206],
                        ]
                    ],
                    ['nombre' => 'operacion',
                        'item' => [
                            ['nombre' => 'turno', 'titulo' => 'Turno', 'entidad' => 'TurTurno', 'ayuda' => 216],
                            ['nombre' => 'secuencia', 'titulo' => 'Secuencia', 'entidad' => 'TurSencuencia', 'ayuda' => 213],
                            ['nombre' => 'salario', 'titulo' => 'Salario', 'entidad' => 'TurSalario', 'ayuda' => 1001],
                            ['nombre' => 'supervisor', 'titulo' => 'Supervisor', 'entidad' => 'TurSupervisor', 'ayuda' => 215],
                            ['nombre' => 'coordinador', 'titulo' => 'Coordinador', 'entidad' => 'TurCoordinador', 'ayuda' => 203],
                            ['nombre' => 'operacion', 'titulo' => 'Operación', 'entidad' => 'TurOperacion', 'ayuda' => 209],
                            ['nombre' => 'zona', 'titulo' => 'Zona', 'entidad' => 'TurZona', 'ayuda' => 1001],
                            ['nombre' => 'proyecto', 'titulo' => 'Proyecto', 'entidad' => 'TurProyecto', 'ayuda' => 1001],
                        ]
                    ],
                    ['nombre' => 'novedad',
                        'item' => [
                            ['nombre' => 'novedadtipo', 'titulo' => 'Novedad tipo', 'entidad' => 'TurNovedadTipo', 'ayuda' => 208],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'proceso',
                'icono' => 'fal fa-database',
                'grupo' => [
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'generarpedido', 'titulo' => 'Generar pedido', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'facturaelectronica', 'titulo' => 'Factura electronica', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'corregirsaldopedido', 'titulo' => 'Corregir saldo pedido', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'corregirhoraspedido', 'titulo' => 'Corregir horas pedido', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'operacion',
                        'item' => [
                            ['nombre' => 'corregirhorasprogramacion', 'titulo' => 'Corregir horas programacion', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                ],
            ],
            [
                'nombre' => 'utilidad',
                'icono' => 'fal fa-bolt',
                'grupo' => [
                    ['nombre' => 'operacion',
                        'item' => [
                            ['nombre' => 'prototipo', 'titulo' => 'Prototipo', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'programacion', 'titulo' => 'Programación', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'analizarinconsistencia', 'titulo' => 'Analizar inconsistencias', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'importarlicencia', 'titulo' => 'Licencias', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'importarincapacidad', 'titulo' => 'Incapacidades', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'importarvacacion', 'titulo' => 'Vacaciones', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'recurso',
                        'item' => [
                            ['nombre' => 'adicionalpuesto', 'titulo' => 'Adicional puesto', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'asignardatos', 'titulo' => 'Asignar datos (contrato)', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'facturamasiva', 'titulo' => 'Factura masiva', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'reliquidarfactura', 'titulo' => 'Reliquidar factura', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'reliquidarpedido', 'titulo' => 'Reliquidar pedido', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'imprimirfacturamasiva', 'titulo' => 'Imprimir factura masiva', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'tablero',
                'icono' => 'fal fa-chart-pie',
                'grupo' => [
                    ['nombre' => 'gerente',
                        'item' => [
                            ['nombre' => 'comercial', 'titulo' => 'Comercial', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'informe',
                'icono' => 'fal fa-th-list',
                'grupo' => [
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'pedido', 'titulo' => 'Pedido', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pedidodetalle', 'titulo' => 'Pedido detalle', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'fechaservicio', 'titulo' => 'Fecha servicio', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendientefacturar', 'titulo' => 'Pendiente facturar', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'factura', 'titulo' => 'Factura', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'facturadetalle', 'titulo' => 'Factura detalle', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'retencionica', 'titulo' => 'RetencionIca', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'juridico',
                        'item' => [
                            ['nombre' => 'contrato', 'titulo' => 'Contrato', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'contratodetalle', 'titulo' => 'Contrato detalle', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'operacion',
                        'item' => [
                            ['nombre' => 'programacion', 'titulo' => 'Programación', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'financiero',
                        'item' => [
                            ['nombre' => 'costoempleado', 'titulo' => 'Costo empleado', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'costoservicio', 'titulo' => 'Costo servicio', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'otros',
                'temas' => [
                    ['titulo' => 'Proceso general', 'ayuda' => 1001],
                ]
            ],
        ];
        $arrIndice['transporte'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'recogida',
                        'item' => [
                            ['nombre' => 'recogida', 'titulo' => 'Recogida', 'entidad' => 'TteRecogida', 'ayuda' => 191],
                            ['nombre' => 'despacho', 'titulo' => 'Despacho', 'entidad' => 'TteDespachoRecogida', 'ayuda' => 171],
                        ]
                    ],
                    ['nombre' => 'transporte',
                        'item' => [
                            ['nombre' => 'guia', 'titulo' => 'Guía', 'entidad' => 'TteGuia', 'ayuda' => 180],
                            ['nombre' => 'despacho', 'titulo' => 'Despacho', 'entidad' => 'Ttedespacho', 'ayuda' => 171],
                            ['nombre' => 'cumplido', 'titulo' => 'Cumplido', 'entidad' => 'TteCumplido', 'ayuda' => 168],
                            ['nombre' => 'documental', 'titulo' => 'Documental', 'entidad' => 'TteDocumental', 'ayuda' => 175],
                            ['nombre' => 'novedad', 'titulo' => 'Novedad', 'entidad' => 'TteNovedad', 'ayuda' => 184],
                            ['nombre' => 'recaudodevolucion', 'titulo' => 'Recaudo devolución', 'entidad' => 'TteRecaudoDevolucion', 'ayuda' => 190],
                            ['nombre' => 'recaudocobro', 'titulo' => 'Recaudo cobro', 'entidad' => 'TteRecaudoCobro', 'ayuda' => 189],
                        ]
                    ],
                    ['nombre' => 'control',
                        'item' => [
                            ['nombre' => 'relacioncaja', 'titulo' => 'Relación caja', 'entidad' => 'TteRelacionCaja', 'ayuda' => 193],
                        ]
                    ],
                    ['nombre' => 'monitoreo',
                        'item' => [
                            ['nombre' => 'monitoreo', 'titulo' => 'Monitoreo', 'entidad' => 'TteMonitoreo', 'ayuda' => 183],
                        ]
                    ],
                    ['nombre' => 'ventas',
                        'item' => [
                            ['nombre' => 'factura', 'titulo' => 'Factura', 'entidad' => 'TteFactura', 'ayuda' => 177],
                        ]
                    ],
                    ['nombre' => 'financiero',
                        'item' => [
                            ['nombre' => 'intermediacion', 'titulo' => 'Intermediacion', 'entidad' => 'TteIntermediacion', 'ayuda' => 182],
                        ]
                    ]


                ],
            ],
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'logistica',
                        'item' => [
                            ['nombre' => 'aseguradora', 'titulo' => 'Aseguradora', 'entidad' => 'TteAseguradora', 'ayuda' => 162],
                            ['nombre' => 'poseedor', 'titulo' => 'Poseedor', 'entidad' => 'TtePoseedor', 'ayuda' => 187],
                            ['nombre' => 'conductor', 'titulo' => 'Conductor', 'entidad' => 'TteConductor', 'ayuda' => 167],
                            ['nombre' => 'vehiculo', 'titulo' => 'Vehiculo', 'entidad' => 'TteVehiculo', 'ayuda' => 197],
                            ['nombre' => 'guiatipo', 'titulo' => 'Guía tipo', 'entidad' => 'TteGuiaTipo', 'ayuda' => 181],
                            ['nombre' => 'producto', 'titulo' => 'Producto', 'entidad' => 'TteProducto', 'ayuda' => 1000],
                            ['nombre' => 'redespachomotivo', 'titulo' => 'Redespacho motivo', 'entidad' => 'TteRedespachoMotivo', 'ayuda' => 1000],
                            ['nombre' => 'destinatario', 'titulo' => 'Destinatario', 'entidad' => 'TteDestinatario', 'ayuda' => 174],
                            ['nombre' => 'empaque', 'titulo' => 'Empaque', 'entidad' => 'TteEmpaque', 'ayuda' => 176],
                            ['nombre' => 'ruta', 'titulo' => 'Ruta', 'entidad' => 'TteRuta', 'ayuda' => 194],
                            ['nombre' => 'rutarecogida', 'titulo' => 'Ruta recogida', 'entidad' => 'TteRutaRecogida', 'ayuda' => 195],
                            ['nombre' => 'novedadtipo', 'titulo' => 'Novedad tipo', 'entidad' => 'TteNovedadTipo', 'ayuda' => 185],
                            ['nombre' => 'auxiliar', 'titulo' => 'Auxiliar', 'entidad' => 'TteAuxiliar', 'ayuda' => 163],
                            ['nombre' => 'despachotipo', 'titulo' => 'Despacho tipo', 'entidad' => 'TteDespachoTipo', 'ayuda' => 173],
                            ['nombre' => 'zona', 'titulo' => 'Zona', 'entidad' => 'TteZona', 'ayuda' => 198],
                        ]
                    ],
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'operacion', 'titulo' => 'Operación', 'entidad' => 'TteAseguradora', 'ayuda' => 1000],
                            ['nombre' => 'departamento', 'titulo' => 'Departamento', 'entidad' => 'TtePoseedor', 'ayuda' => 1000],
                            ['nombre' => 'ciudad', 'titulo' => 'Ciudad', 'entidad' => 'TteConductor', 'ayuda' => 1000],
                            ['nombre' => 'frecuencia', 'titulo' => 'Frecuencia', 'entidad' => 'TteVehiculo', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'item', 'titulo' => 'Ítem', 'entidad' => 'TteItem', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'cliente', 'titulo' => 'Cliente', 'entidad' => 'TteAseguradora', 'ayuda' => 165],
                            ['nombre' => 'precio', 'titulo' => 'Precio', 'entidad' => 'TtePoseedor', 'ayuda' => 188],
                            ['nombre' => 'condicion', 'titulo' => 'Condición', 'entidad' => 'TteConductor', 'ayuda' => 166],
                            ['nombre' => 'facturatipo', 'titulo' => 'Factura tipo', 'entidad' => 'TteVehiculo', 'ayuda' => 179],
                            ['nombre' => 'facturaconcepto', 'titulo' => 'Factura concepto', 'entidad' => 'TteVehiculo', 'ayuda' => 178],
                            ['nombre' => 'facturaconceptodetalle', 'titulo' => 'Factura concepto detalle', 'entidad' => 'TteVehiculo', 'ayuda' => 178],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'proceso',
                'icono' => 'fal fa-database',
                'grupo' => [
                    ['nombre' => 'recogida',
                        'item' => [
                            ['nombre' => 'programada', 'titulo' => 'Programada', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'recoge', 'titulo' => 'Recoge', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'descarga', 'titulo' => 'Descarga', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'despacho',
                        'item' => [
                            ['nombre' => 'entrega', 'titulo' => 'Entrega', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'soporte', 'titulo' => 'Soporte', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'cumplirrndc', 'titulo' => 'Cumplir', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'guia',
                        'item' => [
                            ['nombre' => 'entrega', 'titulo' => 'Entrega', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'soporte', 'titulo' => 'Soporte', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'redespacho', 'titulo' => 'Re-despacho', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'desembarco', 'titulo' => 'Desembarco', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'cortesia', 'titulo' => 'Cortesía', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'generarfactura', 'titulo' => 'Generar factura', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'clienteunificar', 'titulo' => 'Unificar cliente', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'contabilidad',
                        'item' => [
                            ['nombre' => 'factura', 'titulo' => 'Factura', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'despacho', 'titulo' => 'Despacho', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'despachorecogida', 'titulo' => 'Despacho recogida', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'recaudo', 'titulo' => 'Recaudo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'venta',
                        'item' => [
                            ['nombre' => 'facturaelectronica', 'titulo' => 'Factura electrónica', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'utilidad',
                'icono' => 'fal fa-bolt',
                'grupo' => [
                    ['nombre' => 'servicio',
                        'item' => [
                            ['nombre' => 'notificarnovedad', 'titulo' => 'Notificar novedad', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'notificarentrega', 'titulo' => 'Notificar entrega', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'notificarestado', 'titulo' => 'Notificar estado', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'guia',
                        'item' => [
                            ['nombre' => 'correccion', 'titulo' => 'Corrección', 'entidad' => ''],
                            ['nombre' => 'correccionvalores', 'titulo' => 'Corrección valores', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'cargarinformacion', 'titulo' => 'Cargar información', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'precioreexpedicion', 'titulo' => 'Precio reexpedición', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'importarbufalo', 'titulo' => 'Importar bufalo', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'importarexcel', 'titulo' => 'Importar excel', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'imprimirmasivo', 'titulo' => 'Imprimir masivo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'vehiculodisponible', 'titulo' => 'Vehículo disponible', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'recogida',
                        'item' => [
                            ['nombre' => 'correccion', 'titulo' => 'Corrección', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'informe',
                'icono' => 'fal fa-th-list',
                'grupo' => [
                    ['nombre' => 'novedad',
                        'item' => [
                            ['nombre' => 'pendienteatender', 'titulo' => 'Pendiente atender', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendientesolucionar', 'titulo' => 'Pendiente solucionar', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'reportenovedad', 'titulo' => 'Novedad', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'despacho',
                        'item' => [
                            ['nombre' => 'detalle', 'titulo' => 'Detalle', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'siplatf', 'titulo' => 'Siplatf', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'logistica',
                        'item' => [
                            ['nombre' => 'auxiliar', 'titulo' => 'Auxiliar', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'redespacho',
                        'item' => [
                            ['nombre' => 'redespacho', 'titulo' => 'Re-despacho', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'guia',
                        'item' => [
                            ['nombre' => 'pendientedespachoruta', 'titulo' => 'Pendiente despacho ruta', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendienteconductor', 'titulo' => 'Pendiente conductor', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendientesoporte', 'titulo' => 'Pendiente soporte', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendienteentrega', 'titulo' => 'Pendiente entrega', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'guiascliente', 'titulo' => 'Guías cliente', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'estado', 'titulo' => 'Estado', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'desembarco', 'titulo' => 'Desembarco', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendienterecaudodevolucion', 'titulo' => 'Pendiente recaudo devolución', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendienterecaudocobros', 'titulo' => 'Pendiente recaudo cobro', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'entregafecha', 'titulo' => 'Entrega por fecha', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'soportefecha', 'titulo' => 'Soporte por fecha', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'tiempo', 'titulo' => 'Tiempo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'costo',
                        'item' => [
                            ['nombre' => 'general', 'titulo' => 'Costo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'recogida',
                        'item' => [
                            ['nombre' => 'pendienteprogramar', 'titulo' => 'Pendiente programar', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'fecha', 'titulo' => 'Fecha', 'entidad' => ''],
                        ]
                    ],
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'produccioncliente', 'titulo' => 'Producción (Cliente)', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'produccionasesor', 'titulo' => 'Producción (Asesor)', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'factura', 'titulo' => 'Factura', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'facturadetalle', 'titulo' => 'Factura detalle', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendientefactura', 'titulo' => 'Pendiente facturar', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendientefacturacliente', 'titulo' => 'Pendiente facturar cliente', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'control',
                        'item' => [
                            ['nombre' => 'factura', 'titulo' => 'Factura', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'financiero',
                        'item' => [
                            ['nombre' => 'rentabilidad', 'titulo' => 'Rentabilidad despacho', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'costo', 'titulo' => 'Costos', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'tablero',
                'icono' => 'fal fa-chart-pie',
                'grupo' => [
                    ['nombre' => 'recogida',
                        'item' => [
                            ['nombre' => 'resumen', 'titulo' => 'Resumen', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'guia',
                        'item' => [
                            ['nombre' => 'resumen', 'titulo' => 'Resumen', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'pendiente', 'titulo' => 'Pendiente', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'produccion', 'titulo' => 'Produccion', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'costo', 'titulo' => 'Costos', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'despacho',
                        'item' => [
                            ['nombre' => 'resumen', 'titulo' => 'Resumen', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'mes', 'titulo' => 'Despacho por mes', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'detalle', 'titulo' => 'Detalle', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'novedad',
                        'item' => [
                            ['nombre' => 'mes', 'titulo' => 'Novedades por mes', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'desembarco',
                        'item' => [
                            ['nombre' => 'resumen', 'titulo' => 'Resumen', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
        ];
        $arrIndice['recursohumano'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'seleccion',
                        'item' => [
                            ['nombre' => 'aspirante', 'titulo' => 'Aspirante', 'entidad' => 'RhuAspirante', 'ayuda' => 86],
                            ['nombre' => 'solicitud', 'titulo' => 'Solicitud', 'entidad' => 'RhuSolicitud', 'ayuda' => 147],
                            ['nombre' => 'seleccion', 'titulo' => 'Selección', 'entidad' => 'RhuSeleccion', 'ayuda' => 142],
                        ]
                    ],
                    ['nombre' => 'contratacion',
                        'item' => [
                            ['nombre' => 'requisito', 'titulo' => 'Requisitos', 'entidad' => 'RhuRequisitos', 'ayuda' => 139],
                            ['nombre' => 'examen', 'titulo' => 'Examen', 'entidad' => 'RhuExamen', 'ayuda' => 119],

                        ]
                    ],
                    ['nombre' => 'recurso',
                        'item' => [
                            ['nombre' => 'visita', 'titulo' => 'Visita', 'entidad' => 'RhuVisita', 'ayuda' => 155],
                            ['nombre' => 'permiso', 'titulo' => 'Permiso', 'entidad' => 'RhuPermiso', 'ayuda' => 132],
                            ['nombre' => 'poligrafia', 'titulo' => 'Poligrafía', 'entidad' => 'RhuPoligrafia', 'ayuda' => 134],
                            ['nombre' => 'induccion', 'titulo' => 'Inducción', 'entidad' => 'RhuInduccion', 'ayuda' => 126],
                            ['nombre' => 'prueba', 'titulo' => 'Prueba', 'entidad' => 'RhuPrueba', 'ayuda' => 1000],
                            ['nombre' => 'acreditacion', 'titulo' => 'Acreditación', 'entidad' => 'RhuAcreditacion', 'ayuda' => 80],
                            ['nombre' => 'incidente', 'titulo' => 'Incidente', 'entidad' => 'RhuIncidente', 'ayuda' => 124],
                            ['nombre' => 'desempeno', 'titulo' => 'Desempeño', 'entidad' => 'RhuDesempeno', 'ayuda' => 105],
                            ['nombre' => 'estudio', 'titulo' => 'Estudio', 'entidad' => 'RhuEstudio', 'ayuda' => 117],
                            ['nombre' => 'disciplinario', 'titulo' => 'Disciplinario', 'entidad' => 'RhuDisciplinario', 'ayuda' => 106],
                            ['nombre' => 'capacitacion', 'titulo' => 'Capacitación', 'entidad' => 'RhuCapacitacion', 'ayuda' => 88],
                            ['nombre' => 'antecedente', 'titulo' => 'Antecedente', 'entidad' => 'RhuAntecedente', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'ocupacional',
                        'item' => [
                            ['nombre' => 'accidente', 'titulo' => 'Accidente', 'entidad' => 'RhuAccidente', 'ayuda' => 79],
                        ]
                    ],
                    ['nombre' => 'nomina',
                        'item' => [
                            ['nombre' => 'programacion', 'titulo' => 'Programación', 'entidad' => 'RhuProgramacion', 'ayuda' => 136],
                            ['nombre' => 'adicional', 'titulo' => 'Adicional', 'entidad' => 'RhuAdicional', 'ayuda' => 82],
                            ['nombre' => 'adicionalperiodo', 'titulo' => 'Adicional periodo', 'entidad' => 'RhuAdicionalPeriodo', 'ayuda' => 83],
                            ['nombre' => 'pago', 'titulo' => 'Pago', 'entidad' => 'RhuPago', 'ayuda' => 129],
                            ['nombre' => 'incapacidad', 'titulo' => 'Incapacidad', 'entidad' => 'RhuIncapacidad', 'ayuda' => 123],
                            ['nombre' => 'licencia', 'titulo' => 'Licencia', 'entidad' => 'RhuLicencia', 'ayuda' => 127],
                            ['nombre' => 'credito', 'titulo' => 'Crédito', 'entidad' => 'RhuCredito', 'ayuda' => 103],
                            ['nombre' => 'embargo', 'titulo' => 'Embargo y sindicato', 'entidad' => 'RhuEmbargo', 'ayuda' => 110],
                            ['nombre' => 'liquidacion', 'titulo' => 'Liquidación', 'entidad' => 'RhuLiquidacion', 'ayuda' => 128],
                            ['nombre' => 'vacacion', 'titulo' => 'Vacación', 'entidad' => 'RhuVacacion', 'ayuda' => 154],
                            ['nombre' => 'reclamo', 'titulo' => 'Reclamo', 'entidad' => 'RhuReclamo', 'ayuda' => 138],
                        ]
                    ],
                    ['nombre' => 'seguridadsocial',
                        'item' => [
                            ['nombre' => 'aporte', 'titulo' => 'Aporte', 'entidad' => 'RhuAporte', 'ayuda' => 84],

                        ]
                    ],
                    ['nombre' => 'dotacion',
                        'item' => [
                            ['nombre' => 'dotacion', 'titulo' => 'Dotación', 'entidad' => 'RhuDotacionElemento', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'financiero',
                        'item' => [
                            ['nombre' => 'cierremes', 'titulo' => 'Cierre mes', 'entidad' => 'RhuCierre', 'ayuda' => 94],
                            ['nombre' => 'cierreanio', 'titulo' => 'Cierre año', 'entidad' => 'RhuCierreAnio', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'recurso',
                        'item' => [
                            ['nombre' => 'empleado', 'titulo' => 'Empleado', 'entidad' => 'RhuEmpleado', 'ayuda' => 114],
                            ['nombre' => 'contrato', 'titulo' => 'Contrato', 'entidad' => 'RhuContrato', 'ayuda' => 99],
                            ['nombre' => 'visitatipo', 'titulo' => 'Visita tipo', 'entidad' => 'RhuVisitaTipo', 'ayuda' => 156],
                            ['nombre' => 'poligrafiatipo', 'titulo' => 'Poligrafía tipo', 'entidad' => 'RhuPoligrafiaTipo', 'ayuda' => 135],
                            ['nombre' => 'permisotipo', 'titulo' => 'Permiso tipo', 'entidad' => 'RhuPermisoTipo', 'ayuda' => 133],
                            ['nombre' => 'pruebatipo', 'titulo' => 'Prueba tipo', 'entidad' => 'RhuPruebaTipo', 'ayuda' => 137],
                            ['nombre' => 'acreditaciontipo', 'titulo' => 'Acreditación tipo', 'entidad' => 'RhuAcreditacionTipo', 'ayuda' => 81],
                            ['nombre' => 'disciplinariotipo', 'titulo' => 'Disciplinario tipo', 'entidad' => 'RhuDisciplinarioTipo', 'ayuda' => 109],
                            ['nombre' => 'incidentetipo', 'titulo' => 'Incidente tipo', 'entidad' => 'RhuIncidenteTipo', 'ayuda' => 125],
                            ['nombre' => 'capacitaciontipo', 'titulo' => 'Capacitación tipo', 'entidad' => 'RhuCapacitacionTipo', 'ayuda' => 91],
                            ['nombre' => 'metodologiatipo', 'titulo' => 'Metodología tipo', 'entidad' => 'RhuMetodologiaTipo', 'ayuda' => 89],
                            ['nombre' => 'disciplinariofalta', 'titulo' => 'Disciplinario falta', 'entidad' => 'RhuDisciplinarioFalta', 'ayuda' => 107],
                            ['nombre' => 'capacitaciontema', 'titulo' => 'Capacitación tema', 'entidad' => 'RhuCapacitacionTema', 'ayuda' => 90],
                            ['nombre' => 'academia', 'titulo' => 'Academia', 'entidad' => 'RhuAcademia', 'ayuda' => 78],
                            ['nombre' => 'disciplinariomotivo', 'titulo' => 'Disciplinario motivo', 'entidad' => 'RhuDisciplinarioMotivo', 'ayuda' => 108],
                        ]
                    ],
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'cliente', 'titulo' => 'Cliente', 'entidad' => 'RhuCliente', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'nomina',
                        'item' => [
                            ['nombre' => 'concepto', 'titulo' => 'Concepto', 'entidad' => 'RhuConcepto', 'ayuda' => 97],
                            ['nombre' => 'contratotipo', 'titulo' => 'Contrato tipo', 'entidad' => 'RhuContratoTipo', 'ayuda' => 101],
                            ['nombre' => 'novedadtipo', 'titulo' => 'Novedad tipo', 'entidad' => 'RhuNovedadTipo', 'ayuda' => 1000],
                            ['nombre' => 'pagotipo', 'titulo' => 'Pago tipo', 'entidad' => 'RhuPagoTipo', 'ayuda' => 130],
                            ['nombre' => 'creditotipo', 'titulo' => 'Crédito tipo', 'entidad' => 'RhuCreditoTipo', 'ayuda' => 104],
                            ['nombre' => 'embargotipo', 'titulo' => 'Embargo tipo', 'entidad' => 'RhuEmbargoTipo', 'ayuda' => 113],
                            ['nombre' => 'vacaciontipo', 'titulo' => 'Vacación tipo', 'entidad' => 'RhuVacacionTipo', 'ayuda' => 1000],
                            ['nombre' => 'salud', 'titulo' => 'Salud', 'entidad' => 'RhuSalud', 'ayuda' => 141],
                            ['nombre' => 'pension', 'titulo' => 'Pensión', 'entidad' => 'RhuPension', 'ayuda' => 131],
                            ['nombre' => 'tiempo', 'titulo' => 'Tiempo', 'entidad' => 'RhuTiempo', 'ayuda' => 1000],
                            ['nombre' => 'licenciatipo', 'titulo' => 'Licencia tipo', 'entidad' => 'RhuLicenciaTipo', 'ayuda' => 1000],
                            ['nombre' => 'incapacidadtipo', 'titulo' => 'Incapacidad tipo', 'entidad' => 'RhuIncapacidadTipo', 'ayuda' => 1000],
                            ['nombre' => 'incapacidaddiagnostico', 'titulo' => 'Incapacidad diagnóstico', 'entidad' => 'RhuIncapacidadDiagnostico', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'grupo', 'titulo' => 'Grupo', 'entidad' => 'RhuGrupo', 'ayuda' => 122],
                            ['nombre' => 'cargo', 'titulo' => 'Cargo', 'entidad' => 'RhuCargo', 'ayuda' => 92],
                            ['nombre' => 'estudiotipo', 'titulo' => 'Estudio tipo', 'entidad' => 'RhuEstudioTipo', 'ayuda' => 115],
                        ]
                    ],
                    ['nombre' => 'configuracion',
                        'item' => [
                            ['nombre' => 'provision', 'titulo' => 'Provisión', 'entidad' => 'RhuConfiguracionProvision', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'seleccion',
                        'item' => [
                            ['nombre' => 'solicitudmotivo', 'titulo' => 'Solicitud motivo', 'entidad' => 'RhuSolicitudMotivo', 'ayuda' => 149],
                            ['nombre' => 'solicitudexperiencia', 'titulo' => 'Solicitud experiencia', 'entidad' => 'RhuSolicitudExperiencia', 'ayuda' => 148],
                            ['nombre' => 'selecciontipo', 'titulo' => 'Selección tipo', 'entidad' => 'RhuSeleccionTipo', 'ayuda' => 146],
                            ['nombre' => 'seleccionpruebatipo', 'titulo' => 'Selección prueba tipo', 'entidad' => 'RhuSeleccionPruebaTipo', 'ayuda' => 144],
                            ['nombre' => 'seleccionentrevistatipo', 'titulo' => 'Selección entrevista tipo', 'entidad' => 'RhuSeleccionEntrevistaTipo', 'ayuda' => 143],
                            ['nombre' => 'seleccionreferenciatipo', 'titulo' => 'Selección referencia tipo', 'entidad' => 'RhuSeleccionReferenciaTipo', 'ayuda' => 145],
                            ['nombre' => 'seleccionrechazo', 'titulo' => 'Selección rechazo', 'entidad' => 'RhuSeleccionRechazo', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'seguridadsocial',
                        'item' => [
                            ['nombre' => 'clasificacionriesgo', 'titulo' => 'Clasificación riesgo', 'entidad' => 'RhuClasificacionRiesgo', 'ayuda' => 96],
                            ['nombre' => 'sucursal', 'titulo' => 'Sucursal', 'entidad' => 'RhuSucursal', 'ayuda' => 151],
                            ['nombre' => 'aportetipo', 'titulo' => 'Aporte tipo', 'entidad' => 'RhuAporteTipo', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'contratacion',
                        'item' => [
                            ['nombre' => 'requisitocargo', 'titulo' => 'Requisito cargo', 'entidad' => 'RhuRequisitoCargo', 'ayuda' => 1000],
                            ['nombre' => 'requisitotipo', 'titulo' => 'Tipo requisito', 'entidad' => 'RhuRequisitoTipo', 'ayuda' => 1000],
                            ['nombre' => 'requisitoconcepto', 'titulo' => 'Concepto requisito', 'entidad' => 'RhuConceptoRequisito', 'ayuda' => 1000],
                            ['nombre' => 'examentipo', 'titulo' => 'Examen tipo', 'entidad' => 'RhuExamenTipo', 'ayuda' => 121],
                            ['nombre' => 'examenitem', 'titulo' => 'Examen item', 'entidad' => 'RhuExamenItem', 'ayuda' => 120],
                            ['nombre' => 'examenentidad', 'titulo' => 'Examen entidad', 'entidad' => 'RhuExamenEntidad', 'ayuda' => 116],
                            ['nombre' => 'examenlistaprecio', 'titulo' => 'Examen lista precio', 'entidad' => 'RhuExamenListaPrecio', 'ayuda' => 1000],
                            ['nombre' => 'examenrevisiontipo', 'titulo' => 'Examen revisión tipo', 'entidad' => 'RhuExamenRevisionMedicaTipo', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'dotacion',
                        'item' => [
                            ['nombre' => 'dotacionelemento', 'titulo' => 'Elemento', 'entidad' => 'RhuElementos', 'ayuda' => 1000],

                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'utilidad',
                'icono' => 'fal fa-bolt',
                'grupo' => [
                    ['nombre' => 'pago',
                        'item' => [
                            ['nombre' => 'pagomasivo', 'titulo' => 'Imprimir pago masivo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'embargo',
                        'item' => [
                            ['nombre' => 'bancoagrario', 'titulo' => 'Banco agrario', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'certificado',
                        'item' => [
                            ['nombre' => 'ingresoretencion', 'titulo' => 'Ingreso y retención', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'proceso',
                'icono' => 'fal fa-database',
                'grupo' => [
                    ['nombre' => 'pago',
                        'item' => [
                            ['nombre' => 'regeneraribp', 'titulo' => 'Regenerar ibp', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'regenerarprovision', 'titulo' => 'Regenerar provisión', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'credito',
                        'item' => [
                            ['nombre' => 'regenerarsaldo', 'titulo' => 'Regenerar saldo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'recurso',
                        'item' => [
                            ['nombre' => 'reclasificarnombre', 'titulo' => 'Reclasificar nombre', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                ],
            ],
            [
                'nombre' => 'informe',
                'icono' => 'fal fa-th-list',
                'grupo' => [
                    ['nombre' => 'contrato',
                        'item' => [
                            ['nombre' => 'fechaingreso', 'titulo' => 'Fecha ingreso', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'fecharetiro', 'titulo' => 'Fecha terminación', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'cambiosalario', 'titulo' => 'Cambio salario', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'periodo', 'titulo' => 'Periodo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'nomina',
                        'item' => [
                            ['nombre' => 'pago', 'titulo' => 'Pago', 'entidad' => ''],
                            ['nombre' => 'pagodetalle', 'titulo' => 'Pago detalle', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'creditopago', 'titulo' => 'Crédito pago', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'liquidacion', 'titulo' => 'Liquidación', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'recurso',
                        'item' => [
                            ['nombre' => 'empleado', 'titulo' => 'Empleado', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'vacacion',
                        'item' => [
                            ['nombre' => 'pendiente', 'titulo' => 'Pendiente', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'financiero',
                        'item' => [
                            ['nombre' => 'costoempleado', 'titulo' => 'Costo empleado', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'seleccion',
                        'item' => [
                            ['nombre' => 'seleccion', 'titulo' => 'Selección', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'solicitud', 'titulo' => 'Solicitud', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'seguridadsocial',
                        'item' => [
                            ['nombre' => 'aporte', 'titulo' => 'Aporte', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'parafiscales', 'titulo' => 'Parafiscales', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'caja', 'titulo' => 'Caja', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
        ];
        $arrIndice['financiero'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'contabilidad',
                        'item' => [
                            ['nombre' => 'asiento', 'titulo' => 'Asiento', 'entidad' => 'FinAsiento', 'ayuda' => 1000],
                            ['nombre' => 'registro', 'titulo' => 'Registro', 'entidad' => 'FinRegistro', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'tercero', 'titulo' => 'Tercero', 'entidad' => 'FinTercero', 'ayuda' => 1000],
                            ['nombre' => 'cuenta', 'titulo' => 'Cuenta', 'entidad' => 'FinCuenta', 'ayuda' => 1000],
                            ['nombre' => 'comprobante', 'titulo' => 'Comprobante', 'entidad' => 'FinComprobante', 'ayuda' => 1000],
                            ['nombre' => 'centrocosto', 'titulo' => 'Centro costo', 'entidad' => 'FinCentroCosto', 'ayuda' => 1000],

                        ]
                    ]

                ],
            ],
            [
                'nombre' => 'utilidad',
                'icono' => 'fal fa-bolt',
                'grupo' => [
                    ['nombre' => 'intercambio',
                        'item' => [
                            ['nombre' => 'registro', 'titulo' => 'Registro', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'tercero', 'titulo' => 'Tercero', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'contabilidad',
                        'item' => [
                            ['nombre' => 'eliminarmasivo', 'titulo' => 'Eliminar masivo', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'inconsistenciadocumento', 'titulo' => 'Inconsistencia documento', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'verificarconsecutivo', 'titulo' => 'Verificar consecutivo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'informe',
                'icono' => 'fal fa-th-list',
                'grupo' => [
                    ['nombre' => 'contabilidad',
                        'item' => [
                            ['nombre' => 'registro', 'titulo' => 'Registro', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'auxiliar', 'titulo' => 'Auxiliar', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'balanceprueba', 'titulo' => 'Balance prueba', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ]

                ],
            ],
        ];
        $arrIndice['cartera'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'cartera',
                        'item' => [
                            ['nombre' => 'cuentacobrar', 'titulo' => 'Cuenta cobrar', 'entidad' => 'CarCuentaCobrar', 'ayuda' => 7],
                        ]
                    ],
                    ['nombre' => 'movimiento',
                        'item' => [
                            ['nombre' => 'movimiento', 'titulo' => 'Recibo', 'entidad' => 'CarRecibo', 'parametro' => 'clase', 'valor' => 'RC', 'ayuda' => 11],


                        ]
                    ],
                    ['nombre' => 'cliente',
                        'item' => [
                            ['nombre' => 'compromiso', 'titulo' => 'Compromiso', 'entidad' => 'CarCompromiso', 'ayuda' => 6],
                        ]
                    ],
                    ['nombre' => 'descontinuado',
                        'item' => [
                            ['nombre' => 'anticipo', 'titulo' => 'Anticipo', 'entidad' => 'CarAnticipo', 'ayuda' => 1],
                            ['nombre' => 'recibo', 'titulo' => 'Recibo', 'entidad' => 'CarRecibo', 'ayuda' => 11],
                            ['nombre' => 'aplicacion', 'titulo' => 'Aplicación', 'entidad' => 'CarAplicacion', 'ayuda' => 1000],
                        ]
                    ],
                ]
            ],
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'cliente', 'titulo' => 'Cliente', 'entidad' => 'CarCliente', 'ayuda' => 5],
                            ['nombre' => 'movimientotipo', 'titulo' => 'Movimiento tipo', 'entidad' => 'CarMovimientoTipo', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'ingreso',
                        'item' => [
                            ['nombre' => 'recibotipo', 'titulo' => 'Recibo tipo', 'entidad' => 'CarReciboTipo', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'cuentacobrar',
                        'item' => [
                            ['nombre' => 'cuentacobrartipo', 'titulo' => 'Cuenta cobrar tipo', 'entidad' => 'CarCuentaCobrarTipo', 'ayuda' => 1000],

                        ]
                    ],
                ]
            ],
            [
                'nombre' => 'utilidad',
                'icono' => 'fal fa-bolt',
                'grupo' => [
                    ['nombre' => 'recibos',
                        'item' => [
                            ['nombre' => 'imprimirrecibosmasivo', 'titulo' => 'Imprimir recibo masivo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                ]
            ],
            [
                'nombre' => 'proceso',
                'icono' => 'fal fa-database',
                'grupo' => [
                    ['nombre' => 'contabilidad',
                        'item' => [
                            ['nombre' => 'recibo', 'titulo' => 'Recibo', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'ingreso',
                        'item' => [
                            ['nombre' => 'recibomasivo', 'titulo' => 'Recibo masivo', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'cartera',
                        'item' => [
                            ['nombre' => 'ajustepeso', 'titulo' => 'Ajuste al peso', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'corregirsaldos', 'titulo' => 'Corregir saldo cuenta cobrar', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'unificarcliente', 'titulo' => 'Unificar cliente', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'informe',
                'icono' => 'fal fa-th-list',
                'grupo' => [
                    ['nombre' => 'cartera',
                        'item' => [
                            ['nombre' => 'cuentacobrarpendiente', 'titulo' => 'Pendiente', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],


                    ['nombre' => 'recibo',
                        'item' => [
                            ['nombre' => 'recaudo', 'titulo' => 'Recaudo', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'recaudodetalle', 'titulo' => 'Recaudo detalle', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'detalle', 'titulo' => 'Detalle', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ]
            ],
        ];
        $arrIndice['tesoreria'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'documento',
                        'item' => [
                            ['nombre' => 'cuentapagar', 'titulo' => 'Cuenta por pagar', 'entidad' => 'TesCuentasPagar', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'movimiento',
                        'item' => [
                            ['nombre' => 'movimiento', 'titulo' => 'Compra', 'entidad' => 'TesMovimiento', 'parametro' => 'clase', 'valor' => 'CP', 'ayuda' => 1000],
                            ['nombre' => 'movimiento', 'titulo' => 'Nota crédito', 'entidad' => 'TesMovimiento', 'parametro' => 'clase', 'valor' => 'NC', 'ayuda' => 1000],
                            ['nombre' => 'movimiento', 'titulo' => 'Nota débito', 'entidad' => 'TesMovimiento', 'parametro' => 'clase', 'valor' => 'ND', 'ayuda' => 1000],
                            ['nombre' => 'movimiento', 'titulo' => 'Egreso', 'entidad' => 'TesMovimiento', 'parametro' => 'clase', 'valor' => 'EG', 'ayuda' => 1000],
                        ]
                    ]
                ]
            ],
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'tercero', 'titulo' => 'Tercero', 'entidad' => 'TesTercero', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'cuenta pagar',
                        'item' => [
                            ['nombre' => 'cuenta pagar tipo', 'titulo' => 'Cuenta pagar tipo', 'entidad' => 'TesCuentaPagarTipo', 'ayuda' => 1000],
                        ]
                    ],

                ]
            ],
            [
                'nombre' => 'proceso',
                'icono' => 'fal fa-database',
                'grupo' => [
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'unificar cliente', 'titulo' => 'Unificar cliente', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'cuenta pagar',
                        'item' => [
                            ['nombre' => 'regenerar saldos', 'titulo' => 'Regenerar saldo', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ],

                ]
            ],
            [
                'nombre' => 'utilidad',
                'icono' => 'fal fa-bolt',
                'grupo' => [
                    ['nombre' => 'movimiento',
                        'item' => [
                            ['nombre' => 'imprimirmovimientomasivo', 'titulo' => 'Imprimir masivo', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ],
                ]
            ],
            [
                'nombre' => 'informe',
                'icono' => 'fal fa-th-list',
                'grupo' => [
                    ['nombre' => 'cuenta pagar',
                        'item' => [
                            ['nombre' => 'pendientes', 'titulo' => 'Pendientes', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]

                ],
            ]
        ];
        $arrIndice['juridico'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'contratacion',
                        'item' => [
                            ['nombre' => 'contrato', 'titulo' => 'Contrato', 'entidad' => 'JurContrato', 'ayuda' => 1000],
                        ]
                    ],
                ],
            ],
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'cliente', 'titulo' => 'Cliente', 'entidad' => 'JurCliente', 'ayuda' => 1000],
                            ['nombre' => 'compromisotipo', 'titulo' => 'Compromiso tipo', 'entidad' => 'JurCompromisoTipo', 'ayuda' => 1000],
                            ['nombre' => 'compromisoclase', 'titulo' => 'Compromiso clase', 'entidad' => 'JurCompromisoClase', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'informe',
                'icono' => 'fal fa-th-list',
                'grupo' => [
                    ['nombre' => 'contratacion',
                        'item' => [
                            ['nombre' => 'certificacion', 'titulo' => 'Certificación', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'compromiso', 'titulo' => 'Compromiso', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'demanda', 'titulo' => 'Demanda', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'modificacion', 'titulo' => 'Modificación', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'novedad', 'titulo' => 'Novedad', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'poliza', 'titulo' => 'Póliza', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'prorroga', 'titulo' => 'Prórroga', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'reclamo', 'titulo' => 'Reclamo', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'requisito', 'titulo' => 'Requisito', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'tutela', 'titulo' => 'Tutela', 'entidad' => '', 'ayuda' => 1000],

                        ]
                    ]

                ],
            ],
        ];
        $arrIndice['crm'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'negocio', 'titulo' => 'Negocio', 'entidad' => 'CrmNegocio', 'ayuda' => 1000],
                            ['nombre' => 'visita', 'titulo' => 'Visita', 'entidad' => 'CrmVisita', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'comercial',
                        'item' => [
                            ['nombre' => 'cliente', 'titulo' => 'Cliente', 'entidad' => 'CrmCliente', 'ayuda' => 1000],
                            ['nombre' => 'contacto', 'titulo' => 'Contacto', 'entidad' => 'CrmContacto', 'ayuda' => 1000],
                            ['nombre' => 'fase', 'titulo' => 'Fase', 'entidad' => 'CrmFase', 'ayuda' => 1000],
                            ['nombre' => 'visitatipo', 'titulo' => 'Visita tipo', 'entidad' => 'CrmVistaTipo', 'ayuda' => 1000],
                            ['nombre' => 'visitamotivo', 'titulo' => 'Visita motivo', 'entidad' => 'CrmVistaMotivo', 'ayuda' => 1000],
                            ['nombre' => 'canal', 'titulo' => 'Canal', 'entidad' => 'CrmCanal', 'ayuda' => 1000],
                            ['nombre' => 'negociolinea', 'titulo' => 'Negocio Línea', 'entidad' => 'CrmNegocioLinea', 'ayuda' => 1000],
                            ['nombre' => 'negociotipo', 'titulo' => 'Negocio Tipo', 'entidad' => 'CrmNegocioTipo', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
        ];
        $arrIndice['general'] = [
            [
                'nombre' => 'administracion',
                'icono' => 'fal fa-edit',
                'grupo' => [
                    ['nombre' => 'general',
                        'item' => [
                            ['nombre' => 'resolucion', 'titulo' => 'Resolución', 'entidad' => 'GenResolucion', 'ayuda' => 1000],
                            ['nombre' => 'asesor', 'titulo' => 'Asesor', 'entidad' => 'GenAsesor', 'ayuda' => 1000],
                            ['nombre' => 'sexo', 'titulo' => 'Sexo', 'entidad' => 'GenSexo', 'ayuda' => 1000],
                            ['nombre' => 'cuenta', 'titulo' => 'Cuenta', 'entidad' => 'GenCuenta', 'ayuda' => 1000],
                            ['nombre' => 'banco', 'titulo' => 'Banco', 'entidad' => 'GenBanco', 'ayuda' => 1000],
                            ['nombre' => 'estadocivil', 'titulo' => 'Estado civil', 'entidad' => 'GenEstadoCivil', 'ayuda' => 1000],
                            ['nombre' => 'ciudad', 'titulo' => 'Ciudad', 'entidad' => 'GenCiudad', 'ayuda' => 1000],
                            ['nombre' => 'departamento', 'titulo' => 'Departamento', 'entidad' => 'GenDepartamento', 'ayuda' => 1000],
                            ['nombre' => 'pais', 'titulo' => 'País', 'entidad' => 'GenPais', 'ayuda' => 1000],
                            ['nombre' => 'impuesto', 'titulo' => 'Impuesto', 'entidad' => 'GenImpuesto', 'ayuda' => 1000],
                            ['nombre' => 'imagenes', 'titulo' => 'Imagen', 'entidad' => 'GenImagenes', 'ayuda' => 1000],

                        ]
                    ],
                    ['nombre' => 'notificacion',
                        'item' => [
                            ['nombre' => 'notificaciontipo', 'titulo' => 'Tipo notificación', 'entidad' => 'GenNotificacionTipo', 'ayuda' => 1000],
                        ]
                    ],
                    ['nombre' => 'calidad',
                        'item' => [
                            ['nombre' => 'formato', 'titulo' => 'Formato', 'entidad' => 'GenFormato', 'ayuda' => 1000],
                        ]
                    ],
                ]
            ],
            [
                'nombre' => 'informe',
                'icono' => 'fal fa-th-list',
                'grupo' => [
                    ['nombre' => 'seguridad',
                        'item' => [
                            ['nombre' => 'log', 'titulo' => 'Log', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]

                ],
            ],
            [
                'nombre' => 'tablero',
                'icono' => 'fal fa-chart-pie',
                'grupo' => [
                    ['nombre' => 'gerencia',
                        'item' => [
                            ['nombre' => 'resumenturno', 'titulo' => 'Resumen turno', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'resumennomina', 'titulo' => 'Resumen nomina', 'entidad' => '', 'ayuda' => 1000],
                            ['nombre' => 'resumencrm', 'titulo' => 'Resumen crm', 'entidad' => '', 'ayuda' => 1000],
                        ]
                    ]
                ],
            ],
        ];
        $arrIndice['documental'] = [
            [
                'nombre' => 'movimiento',
                'icono' => 'fal fa-window',
                'grupo' => [
                    ['nombre' => 'masivo',
                        'item' => [
                            ['nombre' => 'masivo', 'titulo' => 'Masivo', 'entidad' => 'DocMasivo', 'ayuda' => 1000],

                        ]

                    ],

                ],
            ],

        ];
        return $arrIndice;
    }

}