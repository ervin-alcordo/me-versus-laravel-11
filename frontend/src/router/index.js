import AppLayout from '@/layout/AppLayout.vue';
import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import('@/views/Dashboard.vue')
                },
                {
                    path: '/teams/',
                    name: 'teams',
                    component: () => import('@/views/pages/Teams.vue')
                },
                {
                    path: '/system-wide-parts/',
                    name: 'System Wide Parts',
                    component: () => import('@/views/pages/SystemWideParts.vue')
                }/*,
                {
                    path: '/uikit/table',
                    name: 'table',
                    component: () => import('@/views/uikit/TableDoc.vue')
                }*/
            ]
        },
        {
            path: '/:pathMatch(.*)*',
            redirect: '/pages/notfound'
        },
        {
            path: '/pages/notfound',
            name: 'notfound',
            component: () => import('@/views/pages/NotFound.vue')
        }
    ]
});

export default router;
