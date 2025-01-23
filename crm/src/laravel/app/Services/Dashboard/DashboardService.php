<?php
namespace App\Services\Dashboard;

use App\Enums\ClientStatus;
use App\Http\Requests\Dashboard\GetDashboardRequest;
use App\Models\Client;
use App\Models\Dashboard;
use App\Models\User;
use App\Services\Clients\ClientsService;
use App\Services\Orders\OrderService;
use App\Services\Users\UsersService;

class DashboardService
{
    protected $dashboard;
    protected $clientsService;
    protected $usersService;

    public function __construct(Dashboard $dashboard, ClientsService $clientsService, UsersService $usersService)
    {
        $this->dashboard = $dashboard;
        $this->clientsService = $clientsService;
        $this->usersService = $usersService;
    }

    public function getDashboard(GetDashboardRequest $request)
    {
        $this->dashboard->usersCount = $this->getUsersCount($request);
        $this->dashboard->objectsCount = 500; //TODO: bla bla
        $this->dashboard->orders = OrderService::ordersListDashboard();
        $this->dashboard->clientsCount = $this->getClientsCount($request);
        $this->dashboard->freeClientsCount = $this->getFreeClientsCount();

        return $this->dashboard;
    }

    private function getUsersCount($request)
    {
        if(
            auth()->user()->hasRole('SuperAdmin') ||
            auth()->user()->hasPermissionTo('users.viewAny')
        ) {
            return User::count();
        }
        else if(auth()->user()->hasPermissionTo('users.viewMyOnly'))
        {
            $request['senior_agent_id'] = auth()->user()->id;
            $result = $this->usersService->getItems($request);

            return $result['count'];
        }

        return 0;
    }

    private function getClientsCount($request)
    {
        if(
            auth()->user()->hasRole('SuperAdmin') ||
            auth()->user()->hasPermissionTo('clients.viewAny')
        ) {
//            return Client::count();
            return Client::with('user')
                ->whereHas('user')
                ->where(function ($query) {
                    $query->where('status', '!=', ClientStatus::STATUS_ARCHIVE);
                    $query->orWhereNull('status');
                })->count();
        }
        else if(auth()->user()->hasPermissionTo('clients.viewMyOnly'))
        {
            $request['filterUser'] = auth()->user()->id;
            $result = $this->clientsService->getItems($request);

            return $result['count'];
        }

        return 0;
    }

    private function getFreeClientsCount()
    {
        return Client::whereNull('user_id')->where(function ($query) {
            $query->where('status', '!=', ClientStatus::STATUS_ARCHIVE);
            $query->orWhereNull('status');
        })->count();
    }
}
