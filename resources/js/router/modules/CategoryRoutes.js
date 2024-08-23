import CategoryComponent from "../../components/admin/categories/CategoryComponent";
import CategoryListComponent from "../../components/admin/categories/CategoryListComponent";
import CategoryShowComponent from "../../components/admin/categories/CategoryShowComponent";

export default [
    {
        path: '/admin/categories',
        component: CategoryComponent,
        name: 'admin.category',
        redirect: {name: 'admin.category.list'},
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: 'categories',
            breadcrumb: 'product_categories'
        },
        children: [
            {
                path: 'list',
                component: CategoryListComponent,
                name: 'admin.category.list',
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: 'categories',
                    breadcrumb: ''
                },
            },
            {
                path: "show/:id",
                component: CategoryShowComponent,
                name: "admin.category.show",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "categories",
                    breadcrumb: "view",
                },
            },
        ]
    }
]
