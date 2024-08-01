import { defineStore } from 'pinia'

export const useAppLayout = defineStore(
  'appLayout',
  {
    state: () => {
      return {
        color: '',
        isAbsolute: false,
        isNavFixed: false,
        isPinned: true,
        isTransparent: '',
        showNavs: true,
        showNavbar: true,
        showMain: true,
        showSidenav: true,
        showFooter: true,
        navbarFixed:
          'position-sticky blur shadow-blur left-auto top-1 z-index-sticky px-0 mx-4',
        absolute: 'position-absolute px-4 mx-0 w-100 z-index-2',
      }
    },

    actions: {
      navbarMinimize () {
        const sidenavShow = document.querySelector('.g-sidenav-show')

        sidenavShow.classList.toggle('g-sidenav-hidden')
        sidenavShow.classList.toggle('g-sidenav-pinned')
        this.isPinned = !this.isPinned
      },
      setBgTransparent () {
        this.isTransparent = 'bg-transparent'
      },
      toggleEveryDisplay () {
        this.showNavbar = !this.showNavbar
        this.showSidenav = !this.showSidenav
        this.showFooter = !this.showFooter
      },
      toggleSidebarColor (color) {
        this.isTransparent = color
      },
      unsetBgTransparent (value) {
        this.isTransparent = value || ''
      },
    },
  }
)
