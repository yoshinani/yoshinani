<?php
namespace Infrastructure\DataSources\Database;

use Illuminate\Database\DatabaseManager as DB;

/**
 * Class Bass
 * @package Infrastructure\DataSources\Database
 */
class Bass
{
    protected $db;

    /**
     * Bass constructor.
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }

    public function commit()
    {
        $this->db->commit();
    }

    public function rollBack()
    {
        $this->db->rollBack();
    }
}
