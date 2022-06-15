<?php


namespace App\Repository;


use App\Entity\Archivo;
use App\Entity\ArchivoTipo;
use App\Utilidades\SpaceDO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ArchivoRepository extends ServiceEntityRepository
{
    private $user;
    private $spaceDO;
    public function __construct(ManagerRegistry $registry, TokenStorageInterface $token, SpaceDO $spaceDO)
    {
        parent::__construct($registry, Archivo::class);
        if($token->getToken()) {
            $this->user = $token->getToken()->getUser();
        }
        $this->spaceDO = $spaceDO;
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(DocMasivo::class, 'm')
            ->select('m.codigoMasivoPk')
            ->addSelect('m.identificador')
            ->where('m.codigoMasivoPk <> 0');
        if ($session->get('filtroDocMasivoIdentificador') != '') {
            $queryBuilder->andWhere("m.identificador = {$session->get('filtroDocMasivoIdentificador')}");
        }
        return $queryBuilder;
    }

    public function listaArchivo($tipo, $codigo)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Archivo::class, 'a')
            ->select('a.codigoArchivoPk')
            ->addSelect('a.codigo')
            ->addSelect('a.nombre')
            ->addSelect('a.fecha')
            ->addSelect('a.descripcion')
            ->addSelect('a.usuario')
            ->addSelect('(a.tamano / 1000000) as tamano')
            ->addSelect('a.tipo')
            ->where("a.codigoArchivoTipoFk = '" . $tipo . "'")
            ->andWhere("a.codigo = {$codigo}");
        $arArchivos = $queryBuilder->getQuery()->getResult();
        return $arArchivos;
    }

    public function validarExistencia($tipo, $codigo):bool
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Archivo::class, 'a')
            ->select('a.codigoArchivoPk as archivo')
            ->where("a.codigoArchivoTipoFk = '" . $tipo . "'")
            ->andWhere("a.codigo = '" . $codigo . "'");
        $arArchivos = $queryBuilder->getQuery()->getResult();
        if (count($arArchivos) > 0){
            return true;
        }else {
            return false;
        }
    }

    public function carga($codigoArchivoTipo, $codigo, $extension, $nombre, $tamano, $mimeType, $descripcion, $rutaLocal)
    {
        $em = $this->getEntityManager();
        $arArchivoTipo = $em->getRepository(ArchivoTipo::class)->find($codigoArchivoTipo);
        if($arArchivoTipo) {
            $arUsuario = $this->user;
            $token = bin2hex(random_bytes((30 - (20 % 2)) / 2));
            $rutaDestino = "{$codigoArchivoTipo}_{$codigo}_{$token}.{$extension}";
            $arFichero = new Archivo();
            $arFichero->setFecha(new \DateTime('now'));
            $arFichero->setNombre($nombre);
            $arFichero->setTamano($tamano);
            $arFichero->setTipo($mimeType);
            $arFichero->setArchivoTipoRel($arArchivoTipo);
            $arFichero->setCodigo($codigo);
            $arFichero->setExtensionOriginal($extension);
            if($arUsuario) {
                $arFichero->setUsuario($arUsuario->getUsername());
            }
            $arFichero->setRuta($rutaDestino);
            $arFichero->setDescripcion($descripcion);
            $respuesta = $this->spaceDO->subir($rutaLocal, $rutaDestino, $codigoArchivoTipo, $mimeType);
            if($respuesta['error'] == false) {
                $em->persist($arFichero);
                $em->flush();
                return [
                    'error' => false
                ];
            } else {
                return $respuesta;
            }

        } else {
            return [
                'error' => true,
                'errorMensaje' => 'El tipo de archivo no existe'
            ];
        }

    }

    public function descargar($codigoArchivo)
    {
        $em = $this->getEntityManager();
        $arArchivo = $em->getRepository(Archivo::class)->find($codigoArchivo);
        if($arArchivo) {
            $respuesta = $this->spaceDO->contenido($arArchivo->getRuta(), $arArchivo->getCodigoArchivoTipoFk());
            if($respuesta['error'] == false) {
                return [
                    'error' => false,
                    'nombre' => $arArchivo->getNombre(),
                    'tipo' => $arArchivo->getTipo(),
                    'tamano' => $arArchivo->getTamano(),
                    'contenido' => $respuesta['contenido']
                ];
            } else {
                return $respuesta;
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'El fichero no existe'
            ];
        }

    }
}