<?php
// Archivo: app/Controllers/ReporteController.php
namespace App\Controllers;

use App\Models\PrestamoModel;
use App\Models\UsuarioModel;
use App\Models\LibroModel;
use CodeIgniter\Controller;

// Importamos Dompdf para la generación de PDFs
use Dompdf\Dompdf;
use Dompdf\Options;

class ReporteController extends BaseController
{
    protected $prestamoModel;
    protected $usuarioModel;
    protected $libroModel;

    public function __construct()
    {
        $this->prestamoModel = new PrestamoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->libroModel = new LibroModel();
    }

    /**
     * Vista principal del dashboard de reportes.
     */
    public function index()
    {
        $data = [
            'titulo' => 'Generación de Reportes',
            'menu_activo' => 'reportes',
            'alumnos' => $this->usuarioModel->obtenerAlumnos(), 
            'libros' => $this->libroModel->findAll()
        ];

        $data['contenido'] = view('Administrador/reportes/reportes_dashboard', $data);
        return view('Plantillas/plantilla_admin', $data);
    }

    // ==========================================================
    // === Vistas y Generación de Reportes (Métodos de Reporte)
    // ==========================================================

    /**
     * Reporte 1: Préstamos por Alumno
     */
    public function porAlumno()
    {
        $usuario_id = $this->request->getVar('usuario_id');
        $alumno = $this->usuarioModel->find($usuario_id);

        if (!$alumno) {
            return redirect()->to('/reportes')->with('error', 'Alumno no válido.');
        }

        $datos_reporte = $this->prestamoModel->obtenerPrestamosPorAlumno($usuario_id);

        $data = [
            'tipo_reporte' => 'Préstamos por Alumno',
            'subtitulo' => $alumno['nombre'] . ' ' . $alumno['apellido'] . ' (' . $alumno['correo'] . ')',
            'datos' => $datos_reporte,
            'vista_contenido' => 'reporte_alumno', 
            'is_pdf' => $this->request->getVar('pdf') === 'true',
            'is_print' => $this->request->getVar('print') === 'true',
        ];

        return $this->renderReporte($data);
    }
    
    /**
     * Reporte 2: Préstamos por Libro (Devoluciones y activos)
     */
    public function porLibro()
    {
        $libro_id = $this->request->getVar('libro_id');
        $libro = $this->libroModel->find($libro_id);

        if (!$libro) {
            return redirect()->to('/reportes')->with('error', 'Libro no válido.');
        }

        $datos_reporte = $this->prestamoModel->where('libro_id', $libro_id)
            ->select('prestamos.*, usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario')
            ->join('usuarios', 'usuarios.id = prestamos.usuario_id')
            ->orderBy('fecha_prestamo', 'DESC')
            ->findAll();

        $data = [
            'tipo_reporte' => 'Historial por Libro',
            'subtitulo' => $libro['titulo'] . ' (Autor: ' . $libro['autor'] . ')',
            'datos' => $datos_reporte,
            'vista_contenido' => 'reporte_libro',
            'is_pdf' => $this->request->getVar('pdf') === 'true',
            'is_print' => $this->request->getVar('print') === 'true',
        ];

        return $this->renderReporte($data);
    }

    /**
     * Reporte 3: Libros Disponibles
     */
    public function librosDisponibles()
    {
        $datos_reporte = $this->libroModel->obtenerLibrosDisponiblesConCategoria();

        $data = [
            'tipo_reporte' => 'Inventario de Libros Disponibles',
            'subtitulo' => 'Libros con stock > 0 y estado "Disponible"',
            'datos' => $datos_reporte,
            'vista_contenido' => 'reporte_disponibles',
            'is_pdf' => $this->request->getVar('pdf') === 'true',
            'is_print' => $this->request->getVar('print') === 'true',
        ];

        return $this->renderReporte($data);
    }
    
    /**
     * Reporte 4: Préstamos Activos
     */
    public function prestamosActivos()
    {
        $datos_reporte = $this->prestamoModel->obtenerPrestamosActivosDetallados();

        $data = [
            'tipo_reporte' => 'Préstamos Activos y Pendientes',
            'subtitulo' => 'Préstamos con estado "En proceso"',
            'datos' => $datos_reporte,
            'vista_contenido' => 'reporte_activos',
            'is_pdf' => $this->request->getVar('pdf') === 'true',
            'is_print' => $this->request->getVar('print') === 'true',
        ];

        return $this->renderReporte($data);
    }

    // ==========================================================
    // === Función Central para Renderizado (PDF/Print/View)
    // ==========================================================
    
    protected function renderReporte($data)
    {
        // 1. Preparamos los datos (se usa en reporte_base.php)
        $data['request'] = $this->request; 
        
        // 2. Renderizar el contenido base y la tabla específica
        $html_content = view('Administrador/reportes/reporte_base', $data);
        
        if ($data['is_pdf'] || $data['is_print']) {
            
            // Renderizamos la plantilla limpia para impresión/PDF (incluye el CSS necesario)
            $html_reporte = view('Administrador/reportes/reporte_plantilla_pdf', [
                'contenido' => $html_content, 
                'titulo' => $data['tipo_reporte'],
                'is_print' => $data['is_print']
            ]);

            if ($data['is_pdf']) {
                // *** INTEGRACIÓN DE DOMPDF PARA GENERAR EL PDF ***
                
                $dompdf = new Dompdf();
                
                // Habilitar la carga de recursos externos si es necesario (imágenes)
                $options = new Options();
                $options->set('isRemoteEnabled', true);
                $dompdf->setOptions($options);
                
                $dompdf->loadHtml($html_reporte);
                
                // Configurar el tamaño y orientación del papel
                $dompdf->setPaper('Letter', 'portrait'); 
                
                // Renderizar el HTML a PDF
                $dompdf->render();
                
                // Forzar la descarga del archivo al navegador
                $dompdf->stream($this->cleanFilename($data['tipo_reporte']) . '.pdf', ["Attachment" => true]);
                
                // Detener la ejecución del framework para evitar errores de encabezados
                exit();
                
            } elseif ($data['is_print']) {
                // Para impresión, devolvemos la vista limpia con el script de impresión
                return $html_reporte;
            }
        }

        // 3. Si es vista normal (por defecto), renderizamos dentro de la plantilla admin
        $data['contenido'] = $html_content;
        return view('Plantillas/plantilla_admin', $data);
    }
    
    private function cleanFilename($title)
    {
        // Limpia el nombre para el archivo descargado, quitando acentos y espacios
        return str_replace([' ', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'], 
                           ['_', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'], 
                           $title);
    }
}