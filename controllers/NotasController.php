<?php
namespace API\Controllers;

use PDO;
use Exception;

class NotasController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getNotas() {
        try {
            $stmt = $this->db->prepare('SELECT * FROM notas ORDER BY id DESC');
            $stmt->execute();
            return ['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getNotaById($id) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM notas WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $nota = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$nota) {
                return ['success' => false, 'error' => 'Nota no encontrada'];
            }

            return ['success' => true, 'data' => $nota];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function addNota($notaData) {
        try {
            $stmt = $this->db->prepare('
                INSERT INTO notas 
                (nombre_corto, estado, titulo, encabezado, imagen, categoria, contenido) 
                VALUES 
                (:nombre_corto, :estado, :titulo, :encabezado, :imagen, :categoria, :contenido)
            ');

            $stmt->bindParam(':nombre_corto', $notaData['nombre_corto'], PDO::PARAM_STR);
            $stmt->bindParam(':estado', $notaData['estado'], PDO::PARAM_STR);
            $stmt->bindParam(':titulo', $notaData['titulo'], PDO::PARAM_STR);
            $stmt->bindParam(':encabezado', $notaData['encabezado'], PDO::PARAM_STR);
            $stmt->bindParam(':imagen', $notaData['imagen'], PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $notaData['categoria'], PDO::PARAM_STR);
            $stmt->bindParam(':contenido', $notaData['contenido'], PDO::PARAM_STR);

            $stmt->execute();
            return ['success' => true, 'message' => 'Nota agregada exitosamente', 'id' => $this->db->lastInsertId()];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function updateNota($id, $notaData) {
        try {
            $stmt = $this->db->prepare('
                UPDATE notas 
                SET nombre_corto = :nombre_corto,
                    estado = :estado,
                    titulo = :titulo,
                    encabezado = :encabezado,
                    imagen = :imagen,
                    categoria = :categoria,
                    contenido = :contenido
                WHERE id = :id
            ');

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_corto', $notaData['nombre_corto'], PDO::PARAM_STR);
            $stmt->bindParam(':estado', $notaData['estado'], PDO::PARAM_STR);
            $stmt->bindParam(':titulo', $notaData['titulo'], PDO::PARAM_STR);
            $stmt->bindParam(':encabezado', $notaData['encabezado'], PDO::PARAM_STR);
            $stmt->bindParam(':imagen', $notaData['imagen'], PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $notaData['categoria'], PDO::PARAM_STR);
            $stmt->bindParam(':contenido', $notaData['contenido'], PDO::PARAM_STR);

            $stmt->execute();
            return ['success' => true, 'message' => 'Nota actualizada exitosamente'];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function deleteNota($id) {
        try {
            $stmt = $this->db->prepare('DELETE FROM notas WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return ['success' => true, 'message' => 'Nota eliminada exitosamente'];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}