<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\DealerRepository;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function __construct(
        private UserRepository   $userRepo,
        private DealerRepository $dealerRepo
    ) {}

    public function dashboard(): View
    {
        $user        = auth()->user();
        $dealers     = $this->userRepo->getAllByRole('dealer');
        $totalUsers  = $this->userRepo->getAllByRole('employee')->count()
                     + $dealers->count();

        return view('dashboard.employee', compact('user', 'dealers', 'totalUsers'));
    }

    public function viewDealer(int $id): View
    {
        $dealer  = $this->userRepo->findById($id);

        abort_if(!$dealer || !$dealer->isDealer(), 404, 'Dealer not found.');

        return view('employee.dealer-detail', compact('dealer'));
    }
}
