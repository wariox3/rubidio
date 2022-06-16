<?php

namespace App\Utilidades;
use App\Entity\Articulo;
use Doctrine\Persistence\ManagerRegistry;
use jcobhams\NewsApi\NewsApi;

class Noticias
{
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function extraer() {
        $em = $this->doctrine->getManager();
        #https://newsapi.org/docs/endpoints/top-headlines
        $newsapi = new NewsApi("89f737342950499e8e08432650e08665");
        $noticias = $newsapi->getTopHeadlines(null, null, "co", null, null, null);
        if($noticias) {
            if($noticias->status == 'ok') {
                $articulos = $noticias->articles;
                foreach ($articulos as $articulo) {
                    if($articulo->title) {
                        $arArticulo = $em->getRepository(Articulo::class)->findOneBy(['titulo' => $articulo->title]);
                        if(!$arArticulo) {
                            $fuente = $articulo->source;
                            $arArticulo = new Articulo();
                            $arArticulo->setFuente($fuente->name);
                            $arArticulo->setAutor($articulo->author);
                            $arArticulo->setTitulo($articulo->title);
                            $arArticulo->setDescripcion($articulo->description);
                            $arArticulo->setUrl($articulo->url);
                            $arArticulo->setUrlImagen($articulo->urlToImage);
                            $arArticulo->setFecha(date_create($articulo->publishedAt));
                            $em->persist($arArticulo);
                        }
                    }
                }
                $em->flush();
            }
        }
    }

}