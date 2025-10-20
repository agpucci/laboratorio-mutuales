<?php
namespace Models;
use Core\DB;
use PDOException;

class Mutual{
    public static function all(): array{
        $pdo=DB::pdo();
        $q=$pdo->query('SELECT id,name,validada,created_at,updated_at FROM mutuales WHERE deleted_at IS NULL ORDER BY name ASC');
        return $q->fetchAll();
    }
    public static function recentUpdated(int $limit = 10): array{
        $pdo=DB::pdo();
        $q=$pdo->prepare('SELECT id,name,validada,updated_at FROM mutuales WHERE deleted_at IS NULL ORDER BY updated_at DESC LIMIT ?');
        $q->bindValue(1, $limit, \PDO::PARAM_INT);
        $q->execute(); return $q->fetchAll();
    }
    public static function find(int $id): ?array{
        $pdo=DB::pdo();
        $q=$pdo->prepare('SELECT * FROM mutuales WHERE id=? AND deleted_at IS NULL LIMIT 1');
        $q->execute([$id]); $r=$q->fetch(); return $r?:null;
    }
    public static function create(array $d, int $userId): int{
        $pdo=DB::pdo();
        try{
            $sql='INSERT INTO mutuales 
            (name,paga_coseguro,detalle_coseguro,description,validada,
             codigos,apb,apb_adicional,coseguros,coseguros_adicional,token,autorizacion,elegibilidad,elegibilidad_adicional,validez,planes,receta,domicilio_cubre,domicilio_adicional,credencial,atencion,comentarios,
             cuit,razon_social,factura,nomenclador,domicilio_fact,entrega,correo,telefonos,portal,
             created_at,updated_at)
            VALUES (?,?,?,?,0,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())';
            $stmt=$pdo->prepare($sql);
            $stmt->execute([
                $d['name'],$d['paga_coseguro'],$d['detalle_coseguro'],$d['description'],
                $d['codigos'],$d['apb'],$d['apb_adicional'],$d['coseguros'],$d['coseguros_adicional'],$d['token'],$d['autorizacion'],$d['elegibilidad'],$d['elegibilidad_adicional'],$d['validez'],$d['planes'],$d['receta'],$d['domicilio_cubre'],$d['domicilio_adicional'],$d['credencial'],$d['atencion'],$d['comentarios'],
                $d['cuit'],$d['razon_social'],$d['factura'],$d['nomenclador'],$d['domicilio_fact'],$d['entrega'],$d['correo'],$d['telefonos'],$d['portal']
            ]);
            $id=(int)$pdo->lastInsertId();
            \Models\Audit::log($userId,'mutuales',$id,'CREATE',null,json_encode($d,JSON_UNESCAPED_UNICODE));
            return $id;
        }catch(PDOException $e){
            die('Error al crear mutual: '.$e->getMessage());
        }
    }
    public static function update(int $id, array $d, int $userId): void{
        $pdo=DB::pdo();
        $old=self::find($id);
        try{
            $sql='UPDATE mutuales SET 
                name=?,paga_coseguro=?,detalle_coseguro=?,description=?,validada=0,
                codigos=?,apb=?,apb_adicional=?,coseguros=?,coseguros_adicional=?,token=?,autorizacion=?,elegibilidad=?,elegibilidad_adicional=?,validez=?,planes=?,receta=?,domicilio_cubre=?,domicilio_adicional=?,credencial=?,atencion=?,comentarios=?,
                cuit=?,razon_social=?,factura=?,nomenclador=?,domicilio_fact=?,entrega=?,correo=?,telefonos=?,portal=?,
                updated_at=NOW()
                WHERE id=?';
            $stmt=$pdo->prepare($sql);
            $stmt->execute([
                $d['name'],$d['paga_coseguro'],$d['detalle_coseguro'],$d['description'],
                $d['codigos'],$d['apb'],$d['apb_adicional'],$d['coseguros'],$d['coseguros_adicional'],$d['token'],$d['autorizacion'],$d['elegibilidad'],$d['elegibilidad_adicional'],$d['validez'],$d['planes'],$d['receta'],$d['domicilio_cubre'],$d['domicilio_adicional'],$d['credencial'],$d['atencion'],$d['comentarios'],
                $d['cuit'],$d['razon_social'],$d['factura'],$d['nomenclador'],$d['domicilio_fact'],$d['entrega'],$d['correo'],$d['telefonos'],$d['portal'],
                $id
            ]);
            \Models\Audit::log($userId,'mutuales',$id,'UPDATE',json_encode($old,JSON_UNESCAPED_UNICODE),json_encode($d,JSON_UNESCAPED_UNICODE));
        }catch(PDOException $e){
            die('Error al actualizar mutual: '.$e->getMessage());
        }
    }
    public static function softDelete(int $id, int $userId): void{
        $pdo=DB::pdo();
        $q=$pdo->prepare('UPDATE mutuales SET deleted_at=NOW() WHERE id=?');
        $q->execute([$id]);
        \Models\Audit::log($userId,'mutuales',$id,'DELETE',null,null);
    }
    public static function setValidation(int $id, int $state, int $userId): void{
        $pdo=DB::pdo();
        $q=$pdo->prepare('UPDATE mutuales SET validada=?, updated_at=NOW() WHERE id=?');
        $q->execute([$state?1:0,$id]);
    }
}
