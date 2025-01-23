import VueRouter from "vue-router";
import permissions from "./mixin/permissions.js";

function loadView(view) {
    return () => import(`./${view}.vue`);
}

// Routes
const routes = [
    {
        path: "/statistics/clients",
        name: "statistics.clients",
        component: loadView('components/Pages/Dashboard/Statistics/ClientsStatistics'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'statistics.viewAny', 'statistics.clients'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Статистика по клієнтам"
        }
    },
    {
        path: "/statistics/orders",
        name: "statistics.orders",
        component: loadView('components/Pages/Dashboard/Statistics/OrdersStatistics'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'statistics.viewAny', 'statistics.orders'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Статистика по угодам"
        }
    },
    {
        path: "/statistics/offers",
        name: "statistics.offers",
        component: loadView('components/Pages/Dashboard/Statistics/OffersStatistics'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'statistics.viewAny', 'statistics.offers'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Статистика по показам"
        }
    },
    {
        path: "/statistics/prices",
        name: "statistics.prices",
        component: loadView('components/Pages/Dashboard/Statistics/PricesStatistics'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'statistics.viewAny', 'statistics.prices'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Статистика по цінам"
        }
    },
    {
        path: "/telegram",
        name: "telegram",
        component: loadView('components/Pages/Help/Telegram'),
        meta: {
            auth: {
                roles: ['SuperAdmin'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Telegram Set Webhook"
        }
    },
    {
        path: "/help/clients",
        name: "help",
        component: loadView('components/Pages/Help/Help'),
        meta: {
            layout: "DashboardLayout",
            title: "Часті запитання"
        }
    },
    {
        path: "/",
        name: "index",
        component: loadView('components/Pages/Index/Index'),
        meta: {
            layout: "MainLayout",
            title: "CRM"
        }
    },
    {
        path: "/login",
        name: "login",
        component: loadView('components/Pages/Auth/Login'),
        meta: {
            auth: undefined,
            layout: "MainLayout",
            title: "Логін"
        }
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: loadView('components/Pages/Dashboard/Index/Dashboard'),
        meta: {
            auth: true,
            layout: "DashboardLayout",
            title: "Головна"
        }
    },
    //profile
    {
        path: "/profile",
        name: "profile",
        component: loadView('components/Pages/Dashboard/Profile/ProfileIndex'),
        meta: {
            auth: true,
            layout: "DashboardLayout",
            title: "Профіль"
        }
    },

    //Roles
    {
        path: "/roles",
        name: "roles",
        component: loadView('components/Pages/Dashboard/Roles/RolesList'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'roles.viewAny'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Ролі"
        }
    },

    {
        path: "/roles/create",
        name: "roles.create",
        component: loadView('components/Pages/Dashboard/Roles/RolesCreate'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'roles.create'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Ролі"
        }
    },

    {
        path: "/roles/:id",
        name: "roles.update",
        component: loadView('components/Pages/Dashboard/Roles/RolesUpdate'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'roles.update'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Ролі"
        }
    },
    //Users
    {
        path: "/users",
        name: "users",
        component: loadView('components/Pages/Dashboard/Users/UsersList'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'users.viewAny', 'users.viewMyOnly'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Користувачі"
        }
    },

    {
        path: "/users/create",
        name: "users.create",
        component: loadView('components/Pages/Dashboard/Users/UsersCreate'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'users.create'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Користувачі"
        }
    },

    {
        path: "/users/:id",
        name: "users.update",
        component: loadView('components/Pages/Dashboard/Users/UsersUpdate'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'users.update'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Користувачі"
        }
    },

    //Clients
    {
        path: "/clients/list",
        name: "clients",
        component: loadView('components/Pages/Dashboard/Clients/ClientsList'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'clients.viewAny', 'clients.viewMyOnly'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Клієнти"
        }
    },

    {
        path: "/clients/create",
        name: "clients.create",
        component: loadView('components/Pages/Dashboard/Clients/ClientsCreate'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'clients.create'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Клієнти"
        }
    },


    {
        path: "/clients/:id",
        name: "clients.update",
        component: loadView('components/Pages/Dashboard/Clients/ClientsUpdate'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'clients.update'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Клієнти"
        }
    },

    //System

    //LogsRecords
    {
        path: "/system/logs",
        name: "system.logs",
        component: loadView('components/Pages/Dashboard/System/LogsRecords/LogRecordsList'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'logs.viewAny'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Лог помилок"
        }
    },

    {
        path: "/system/logs/:id",
        name: "system.logs.view",
        component: loadView('components/Pages/Dashboard/System/LogsRecords/LogRecordsView'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'logs.viewAny', 'logs.view'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Лог помилок"
        }
    },

    {
        path: "/site/logs",
        name: "site.logs",
        component: loadView('components/Pages/Dashboard/System/SiteLog/LogRecordsList'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'actions.viewAny', 'actions.view'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Лог сайту"
        }
    },

    {
        path: "/site/logs/:id",
        name: "site.logs.view",
        component: loadView('components/Pages/Dashboard/System/SiteLog/LogRecordsView'),
        meta: {
            auth: {
                roles: ['SuperAdmin', 'actions.viewAny', 'actions.view'],
                rolesKey: 'permissions'
            },
            layout: "DashboardLayout",
            title: "Лог сайту"
        }
    },


    //errors

    {
        path: "/403",
        name: "error-403",
        component: loadView('components/Pages/Errors/403'),
        meta: {
            layout: "ErrorLayout",
            title: "403"
        }
    },
    {
        path: "/404",
        name: "error-404-page",
        component: loadView('components/Pages/Errors/404'),
        meta: {
            layout: "ErrorLayout",
            title: "404"
        }
    },
    {
        path: "*",
        name: "error-404",
        component: loadView('components/Pages/Errors/404'),
        meta: {
            layout: "ErrorLayout",
            title: "404"
        }
    },
];

const router = new VueRouter({
    history: true,
    mode: "history",
    linkExactActiveClass: "link-active",
    routes
});

export default router;
