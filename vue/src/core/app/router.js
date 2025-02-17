import { createRouter, createWebHistory } from 'vue-router';

import Main from '@/components/layouts/Main.vue';
import Empty from '@/components/layouts/Empty.vue';

import authRoutes from '@/modules/auth/routes';
import boxRoutes from '@/modules/box/routes';
import sectionRoutes from '@/modules/section/routes';
import systemRoutes from '@/modules/system/routes';
import userRoutes from '@/modules/user/routes';

let mainLayout = [
    {
        path: '',
        component: () => import('@/views/Home.vue'),
    },
];

mainLayout = mainLayout.concat(boxRoutes);
mainLayout = mainLayout.concat(sectionRoutes);
mainLayout = mainLayout.concat(systemRoutes);
mainLayout = mainLayout.concat(userRoutes);

let emptyLayout = authRoutes;

export default createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            component: Main,
            children: mainLayout,
        },
        {
            path: '/:locale',
            component: Main,
            children: mainLayout,
        },
        {
            path: '/',
            component: Empty,
            children: emptyLayout.concat([
                {
                    path: '/:pathMatch(.*)*',
                    component: () => import('@/views/Error.vue'),
                },
            ]),
        },
        {
            path: '/:locale',
            component: Empty,
            children: emptyLayout,
        },
    ],
});
