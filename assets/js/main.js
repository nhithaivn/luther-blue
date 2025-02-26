/**
 * Main JavaScript file for the theme
 * @author Your Name
 */

(function () {
  'use strict';

  // Configuration
  const CONFIG = {
    BREAKPOINTS: {
      DESKTOP: 768,
    },
    CLASSES: {
      ACTIVE: 'is-active',
      SITE_NAV: '.site-nav',
      SITE_NAV_TOGGLE: '.site-nav__toggle',
      SITE_NAV_MENU: '.site-nav__menu',
      MENU_ITEM: '.menu-item',
      SUB_MENU: '.sub-menu',
    },
    ARIA_LABELS: {
      OPEN: 'Ouvrir le menu',
      CLOSE: 'Fermer le menu',
    },
  };

  /**
   * Debounce function
   */
  const debounce = (func, wait = 250) => {
    let timeout;
    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  };

  /**
   * Mobile menu handler class
   */
  class MobileMenu {
    constructor() {
      console.log('🚀 Initializing MobileMenu...');

      // DOM Elements
      this.menuToggle = document.querySelector(CONFIG.CLASSES.SITE_NAV_TOGGLE);
      this.siteNav = document.querySelector(CONFIG.CLASSES.SITE_NAV);
      this.primaryMenu = document.querySelector(CONFIG.CLASSES.SITE_NAV_MENU);
      this.menuItems = document.querySelectorAll(CONFIG.CLASSES.MENU_ITEM);

      // Log DOM elements
      console.log('📍 DOM Elements found:', {
        menuToggle: this.menuToggle,
        siteNav: this.siteNav,
        primaryMenu: this.primaryMenu,
        menuItems: this.menuItems.length,
      });

      if (!this.validateElements()) {
        console.error('❌ Required elements not found - initialization stopped');
        return;
      }

      this.init();
    }

    validateElements() {
      if (!this.menuToggle) {
        console.error('❌ Menu toggle button not found:', CONFIG.CLASSES.SITE_NAV_TOGGLE);
        return false;
      }
      if (!this.siteNav) {
        console.error('❌ Site navigation not found:', CONFIG.CLASSES.SITE_NAV);
        return false;
      }
      if (!this.primaryMenu) {
        console.error('❌ Primary menu not found:', CONFIG.CLASSES.SITE_NAV_MENU);
        return false;
      }
      console.log('✅ All required elements found');
      return true;
    }

    init() {
      console.log('🎯 Initializing menu components...');
      this.setInitialState();
      this.bindEvents();
      this.setupSubMenus();
      console.log('✅ Menu initialization complete');
    }

    setInitialState() {
      console.log('📝 Setting initial menu state...');
      try {
        this.menuToggle.setAttribute('aria-expanded', 'false');
        this.menuToggle.setAttribute('aria-label', CONFIG.ARIA_LABELS.OPEN);
        this.primaryMenu.setAttribute('aria-hidden', 'true');
        console.log('✅ Initial state set successfully');
      } catch (error) {
        console.error('❌ Error setting initial state:', error);
      }
    }

    bindEvents() {
      console.log('🔗 Binding events...');

      // Menu toggle
      this.menuToggle.addEventListener('click', e => {
        console.log('👆 Menu toggle clicked');
        e.stopPropagation();
        this.handleToggleClick(e);
      });

      // Outside click
      document.addEventListener('click', e => {
        if (!this.menuToggle.contains(e.target)) {
          console.log('👆 Document clicked, checking if outside menu');
          this.handleOutsideClick(e);
        }
      });

      // Resize
      window.addEventListener(
        'resize',
        debounce(() => {
          console.log('📐 Window resized');
          this.handleResize();
        })
      );

      // Keyboard
      document.addEventListener('keydown', e => {
        console.log('⌨️ Key pressed:', e.key);
        this.handleKeyboard(e);
      });

      console.log('✅ Events bound successfully');
    }

    setupSubMenus() {
      console.log('🔧 Setting up submenus...');
      this.menuItems.forEach((item, index) => {
        const subMenu = item.querySelector(CONFIG.CLASSES.SUB_MENU);
        if (subMenu) {
          console.log(`📍 Submenu found for item ${index}`);
          const link = item.querySelector('a');
          if (window.innerWidth < CONFIG.BREAKPOINTS.DESKTOP) {
            link.addEventListener('click', e => {
              console.log(`👆 Submenu link ${index} clicked`);
              if (!subMenu.classList.contains(CONFIG.CLASSES.ACTIVE)) {
                e.preventDefault();
                this.toggleSubMenu(subMenu);
              }
            });
          }
        }
      });
    }

    toggleSubMenu(subMenu) {
      console.log('🔄 Toggling submenu');
      const isExpanded = subMenu.classList.contains(CONFIG.CLASSES.ACTIVE);
      subMenu.classList.toggle(CONFIG.CLASSES.ACTIVE);
      subMenu.setAttribute('aria-hidden', !isExpanded);
      console.log('✅ Submenu toggled:', !isExpanded);
    }

    handleToggleClick(event) {
      console.log('🎯 Handling toggle click');
      event.preventDefault();
      const isExpanded = this.menuToggle.getAttribute('aria-expanded') === 'true';
      console.log('Current menu state:', isExpanded ? 'expanded' : 'collapsed');
      this.toggleMenu(!isExpanded);
    }

    handleOutsideClick(event) {
      console.log('🎯 Checking outside click');
      if (
        !this.siteNav.contains(event.target) &&
        this.primaryMenu.classList.contains(CONFIG.CLASSES.ACTIVE)
      ) {
        console.log('📍 Click was outside menu - closing');
        this.toggleMenu(false);
      }
    }

    handleResize() {
      console.log('🎯 Handling resize');
      if (window.innerWidth >= CONFIG.BREAKPOINTS.DESKTOP) {
        console.log('📍 Desktop breakpoint reached - resetting menu');
        this.toggleMenu(false);
        this.resetSubMenus();
      }
    }

    resetSubMenus() {
      console.log('🔄 Resetting submenus');
      const activeSubMenus = this.primaryMenu.querySelectorAll(
        `${CONFIG.CLASSES.SUB_MENU}.${CONFIG.CLASSES.ACTIVE}`
      );
      activeSubMenus.forEach(subMenu => {
        subMenu.classList.remove(CONFIG.CLASSES.ACTIVE);
        subMenu.setAttribute('aria-hidden', 'true');
      });
      console.log('✅ Submenus reset complete');
    }

    handleKeyboard(event) {
      if (event.key === 'Escape' && this.primaryMenu.classList.contains(CONFIG.CLASSES.ACTIVE)) {
        console.log('⌨️ Escape pressed - closing menu');
        this.toggleMenu(false);
      }
    }

    toggleMenu(show) {
      console.log('🔄 Toggling menu:', show ? 'open' : 'close');

      try {
        // Log current state before changes
        console.log('Before toggle:', {
          siteNavClasses: this.siteNav.className,
          primaryMenuClasses: this.primaryMenu.className,
          ariaExpanded: this.menuToggle.getAttribute('aria-expanded'),
        });

        // Apply changes
        this.siteNav.classList.toggle(CONFIG.CLASSES.ACTIVE, show);
        this.primaryMenu.classList.toggle(CONFIG.CLASSES.ACTIVE, show);
        this.menuToggle.setAttribute('aria-expanded', show);
        this.primaryMenu.setAttribute('aria-hidden', !show);
        this.menuToggle.setAttribute(
          'aria-label',
          show ? CONFIG.ARIA_LABELS.CLOSE : CONFIG.ARIA_LABELS.OPEN
        );

        // Log state after changes
        console.log('After toggle:', {
          siteNavClasses: this.siteNav.className,
          primaryMenuClasses: this.primaryMenu.className,
          ariaExpanded: this.menuToggle.getAttribute('aria-expanded'),
        });

        if (!show) {
          this.resetSubMenus();
        }

        console.log('✅ Menu toggle complete');
      } catch (error) {
        console.error('❌ Error toggling menu:', error);
      }
    }
  }

  /**
   * Initialize when DOM is ready
   */
  document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 DOM ready - initializing mobile menu');
    try {
      new MobileMenu();
    } catch (error) {
      console.error('❌ Error initializing mobile menu:', error);
    }
  });
})();
