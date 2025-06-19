<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller {
    public function login() {
        return $this->view('auth/login');
    }

    public function handleLogin() {
        // Aquí va la lógica de autenticación
        header('Location: /dashboard');
    }

    public function dashboard() {
        return $this->view('auth/dashboard');
    }
}

