<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use Exception;
use PsrPHP\Database\Db;

class Account
{

    private $db;

    public function __construct(
        Db $db
    ) {
        $this->db = $db;
    }

    public function getId(string $name): ?int
    {
        return $this->db->get('psrphp_admin_account', 'id', [
            'name' => $name,
        ]) ?: null;
    }

    public function getName(int $id): ?string
    {
        return $this->db->get('psrphp_admin_account', 'name', [
            'id' => $id,
        ]) ?: null;
    }

    public function checkAuth(int $id, string $node): bool
    {
        if ($id == 1) {
            return true;
        }

        if (!is_string($node)) {
            return false;
        }

        static $nodes;
        if (!$nodes) {
            $nodes = $this->db->select('psrphp_admin_auth', 'node', [
                'role_id' => $this->db->select('psrphp_admin_account_role', 'role_id', [
                    'account_id' => $id,
                ]) ?: ['_'],
            ]);
        }

        return in_array($node, $nodes);
    }

    public function setName(int $id, string $name)
    {
        if ($this->db->get('psrphp_admin_account', '*', [
            'name' => $name,
            'id[!]' => $id,
        ])) {
            throw new Exception('账户重复！');
        }
        $this->db->update('psrphp_admin_account', [
            'name' => $name,
        ], [
            'id' => $id,
        ]);
    }

    public function setPassword(int $id, string $password)
    {
        $this->db->update('psrphp_admin_account', [
            'password' => $this->makePassword($password)
        ], [
            'id' => $id,
        ]);
    }

    public function setData(int $id, string $key, $value)
    {
        if ($this->db->get('psrphp_admin_info', '*', [
            'account_id' => $id,
            'key' => $key,
        ])) {
            $this->db->update('psrphp_admin_info', [
                'value' => serialize($value),
            ], [
                'account_id' => $id,
                'key' => $key,
            ]);
        } else {
            $this->db->insert('psrphp_admin_info', [
                'account_id' => $id,
                'key' => $key,
                'value' => serialize($value),
            ]);
        }
    }

    public function getData(int $id, string $key, $default = null)
    {
        if ($data = $this->db->get('psrphp_admin_info', '*', [
            'account_id' => $id,
            'key' => $key,
        ])) {
            return unserialize($data['value']);
        } else {
            return $default;
        }
    }

    public function checkPassword(int $id, string $password): bool
    {
        if ($this->db->get('psrphp_admin_account', 'password', [
            'id' => $id,
        ]) == $this->makePassword($password)) {
            return true;
        }
        return false;
    }

    public function makePassword(string $password): string
    {
        return md5($password . ' love psrphp forever!');
    }
}
