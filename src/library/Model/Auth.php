<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use Exception;
use PsrPHP\Database\Db;
use PsrPHP\Session\Session;

class Auth
{

    private $db;
    private $session;

    public function __construct(
        Session $session,
        Db $db
    ) {
        $this->session = $session;
        $this->db = $db;
    }

    public function isLogin(): bool
    {
        return $this->session->has('admin_id');
    }

    public function login(string $name, string $password): bool
    {
        if (!$id = $this->db->get('psrphp_admin_account', 'id', [
            'name' => $name,
        ])) {
            return false;
        }
        if ($this->verifyPassword($id, $password)) {
            $this->session->set('admin_id', $id);
            return true;
        }
        return false;
    }

    public function logout(): bool
    {
        $this->session->delete('admin_id');
        return true;
    }

    public function getId(): int
    {
        if (!$this->isLogin()) {
            throw new Exception('未登录');
        }
        return $this->session->get('admin_id');
    }

    private function verifyPassword(int $id, string $password): bool
    {
        if ($this->db->get('psrphp_admin_account', 'password', [
            'id' => $id,
        ]) == $this->makePassword($password)) {
            return true;
        }
        return false;
    }

    private function makePassword(string $password): string
    {
        return md5($password . ' love psrphp forever!');
    }
}
