import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/useAuthStore'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      component: () => import('../pages/home/HomePage.vue'),
      meta: { public: true }
    },
    {
      path: '/auth/login',
      component: () => import('../pages/auth/LoginPage.vue'),
      meta: { public: true }
    },
    {
      path: '/vehicles',
      component: () => import('../pages/vehicles/VehiclesPage.vue')
    },
    {
      path: '/vehicles/:id',
      component: () => import('../pages/vehicles/VehicleDetailsPage.vue')
    },
    {
      path: '/proposals',
      component: () => import('../pages/proposals/ProposalsPage.vue')
    },
    {
      path: '/proposals/:id',
      component: () => import('../pages/proposals/ProposalDetailsPage.vue')
    },
    {
      path: '/sales',
      component: () => import('../pages/sales/SalesPage.vue')
    },
    {
      path: '/customers',
      component: () => import('../pages/customers/CustomersPage.vue')
    }
  ]
})

router.beforeEach((to, _from, next) => {
  const authStore = useAuthStore()

  if (!to.meta.public && !authStore.isAuthenticated) {
    return next('/auth/login')
  }

  return next()
})

export default router

