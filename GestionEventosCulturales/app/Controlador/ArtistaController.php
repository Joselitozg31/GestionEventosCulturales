<?php

namespace App\Controlador;

use App\Utils\Utils;
use App\Model\Artista;
use Kint\Kint;

class ArtistaController
{
    private $registrosPorPagina = 10; // Ajusta este valor según tus necesidades

    // Función para mostrar la lista de artistas
    public function mostrarArtistas($datos)
    {
        // Obtener la página actual
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

        // Obtener los artistas
        $con = Utils::getConnection();
        $artistaM = new Artista($con);
        $artistas = $artistaM->cargarTodoPaginado($pagina, $this->registrosPorPagina);
        $totalArtistas = $artistaM->contarTodos();

        $totalPaginas = ceil($totalArtistas / $this->registrosPorPagina);
        $datos = compact("artistas", "pagina", "totalPaginas");

        // Usar Kint para depuración
        d($artistas);

        Utils::render('artistas/lista', $datos);
    }

    // Función para mostrar un artista
    public function mostrarArtista($datos)
    {
        // Obtener la página actual
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

        // Obtener el artista
        $con = Utils::getConnection();
        $artistaM = new Artista($con);
        $artista = $artistaM->cargar($datos['id']);
        $datos = compact("artista", "pagina");

        Utils::render('artistas/ver', $datos);
    }

    // Función para crear un artista
    public function crearArtista()
    {
        // Mostrar el formulario para crear un artista
        Utils::render('artistas/crear');
    }

    // Función para insertar un artista
    public function insertarArtista()
    {
        // Insertar el artista en la base de datos
        $artista = $_POST;

        $con = Utils::getConnection();
        $artistaM = new Artista($con);
        $artistaM->insertar($artista);

        // Calcular la página en la que se encuentra el nuevo registro
        $totalArtistas = $artistaM->contarTodos();
        $pagina = ceil($totalArtistas / $this->registrosPorPagina);

        // Redirigir a la lista de artistas
        Utils::redirect("/artistas?pagina=$pagina");
    }

    // Función para eliminar un artista
    public function eliminarArtista($datos)
    {
        // Eliminar el artista de la base de datos
        $id = $datos['id'];
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

        $con = Utils::getConnection();
        $artistaM = new Artista($con);
        $artistaM->borrar($id);

        // Redirigir a la lista de artistas
        Utils::redirect("/artistas?pagina=$pagina");
    }

    // Función para modificar un artista
    public function modificarArtista($datos)
    {
        // Modificar el artista en la base de datos
        $id = $datos['id'];
        $artista = $_POST;

        $con = Utils::getConnection();
        $artistaM = new Artista($con);
        $artistaM->modificar($id, $artista);

        // Redirigir a la lista de artistas
        Utils::redirect("/artistas?pagina=" . (isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1));
    }

    // Función para mostrar el formulario de modificación de un artista
    public function mostrarModificarArtista($datos)
    {
        // Mostrar el formulario para modificar un artista
        $id = $datos['id'];

        $con = Utils::getConnection();
        $artistaM = new Artista($con);
        $artista = $artistaM->cargar($id);
        $datos = compact("artista");

        Utils::render('artistas/modificar', $datos);
    }
}