<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // ==========================================
    // 1. CRUD DE COLABORADORES (Admins e Funcionários)
    // ==========================================

    public function index()
    {
        // Lista apenas Administradores ('A') e Funcionários ('F')
        $users = User::whereIn('user_type', ['A', 'F'])->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'in:A,F'],
            'gender' => ['required', 'in:M,F,O'], // ADICIONADO: Validação do género
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
            'gender' => $validated['gender'], // ADICIONADO: Gravação do género
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Colaborador criado com sucesso!');
    }

    public function edit(User $user)
    {
        // Trava de segurança: garantir que não se edita clientes aqui
        if ($user->user_type === 'C') {
            abort(403, 'Acesso não autorizado. Use a área de clientes.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->user_type === 'C')
            abort(403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', \Illuminate\Validation\Rule::unique(User::class)->ignore($user->id)],
            'user_type' => ['required', 'in:A,F'],
            'gender' => ['required', 'in:M,F'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        if ($user->user_type === 'C')
            abort(403);

        // Trava de segurança: Impede o administrador de apagar a própria conta
        if (auth()->id() === $user->id) {
            return back()->withErrors(['error' => 'Não podes apagar a tua própria conta!']);
        }

        $user->delete(); // A vossa BD tem softDeletes, logo apenas preenche o deleted_at

        return redirect()->route('admin.users.index')->with('success', 'Colaborador removido com sucesso!');
    }

    // ==========================================
    // 2. GESTÃO DE CLIENTES
    // ==========================================

    public function clientsIndex()
    {
        // withTrashed() garante que os clientes apagados (soft delete) também aparecem na lista
        $clients = User::withTrashed()->where('user_type', 'C')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function toggleBlock($id)
    {
        // Encontra o utilizador pelo ID, mesmo que esteja apagado (trashed)
        $user = User::withTrashed()->findOrFail($id);

        if ($user->user_type !== 'C') {
            abort(403, 'Apenas podes bloquear/desbloquear clientes.');
        }

        // Inverte o estado atual do bloqueio
        $user->blocked = !$user->blocked;
        $user->save();

        $status = $user->blocked ? 'bloqueado' : 'desbloqueado';

        return back()->with('success', "O cliente foi {$status} com sucesso!");
    }

    public function destroyClient($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->user_type !== 'C') {
            abort(403, 'Apenas podes apagar clientes aqui.');
        }

        // Se já estiver apagado, restaura. Se não estiver, apaga (soft delete).
        if ($user->trashed()) {
            $user->restore();
            return back()->with('success', 'Conta de cliente restaurada com sucesso!');
        } else {
            $user->delete();
            return back()->with('success', 'Conta de cliente apagada (Soft Delete) com sucesso!');
        }
    }
}
