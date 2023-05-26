<?php

declare(strict_types=1);

namespace App\Psrphp\Admin\Model;

use App\Psrphp\Admin\Http\Auth\Login;
use App\Psrphp\Admin\Http\Auth\Logout;
use App\Psrphp\Admin\Http\Index;
use App\Psrphp\Admin\Http\Menu\Index as MenuIndex;
use App\Psrphp\Admin\Http\Menu\Stick;
use App\Psrphp\Admin\Http\Tool\Captcha;
use PsrPHP\Database\Db;
use PsrPHP\Session\Session;
use Exception;

class Account
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
        return $this->session->has('admin_account_id');
    }

    public function loginById(int $account_id, string $password): bool
    {
        if ($this->verifyPassword($account_id, $password)) {
            $this->session->set('admin_account_id', $account_id);
            return true;
        }
        return false;
    }

    public function loginByName(string $name, string $password): bool
    {
        if (!$account_id = $this->db->get('psrphp_admin_account', 'id', [
            'name' => $name,
        ])) {
            return false;
        }
        if ($this->verifyPassword($account_id, $password)) {
            $this->session->set('admin_account_id', $account_id);
            return true;
        }
        return false;
    }

    public function logout(): bool
    {
        $this->session->delete('admin_account_id');
        return true;
    }

    public function getAccountId(): int
    {
        if (!$this->isLogin()) {
            throw new Exception("未登录");
        }
        return (int)$this->session->get('admin_account_id');
    }

    public function checkAuth($node): bool
    {
        $account_id = $this->getAccountId();
        if ($account_id == 1) {
            return true;
        }

        if (!is_string($node)) {
            return false;
        }

        static $nodes;
        if (!$nodes) {
            $nodes = $this->db->select('psrphp_admin_role_node', 'node', [
                'role_id' => $this->db->select('psrphp_admin_account_role', 'role_id', [
                    'account_id' => $account_id,
                ]) ?: ['_'],
            ]);
            $nodes[] = Logout::class;
            $nodes[] = Index::class;
            $nodes[] = MenuIndex::class;
            $nodes[] = Stick::class;
        }

        return in_array($node, $nodes);
    }

    private function verifyPassword(int $account_id, string $password): bool
    {
        if ($this->db->get('psrphp_admin_account', 'password', [
            'id' => $account_id,
        ]) == self::makePassword($password)) {
            return true;
        }
        return false;
    }

    public static function makePassword(string $password): string
    {
        return md5($password . ' love psrphp forever!');
    }
}
