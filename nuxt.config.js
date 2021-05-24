export default {
  ssr: false,
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'WebsoftPay',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type:'image/png', href: '/icon.png' } 
    ]
  },
  pwa: {
    meta: {
      title: 'Websoftpay',
      author: 'Itoro E. Philip',
    },
    manifest: {
      name: 'Websoftpay',
      short_name: 'Websoftpay',
      lang: 'en',
      display:'standalone',
      start_url:'/',
      useWebmanifestExtension: false,
      description:'Websoft-pay is a payment application',
      background_color: "#17a2b8",
      theme_color: "#17a2b8",
      splash_pages: "/"

    },
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    "@/node_modules/bootstrap/dist/css/bootstrap.min.css",
    "@/assets/css/style.css",
    "@/assets/font-awesome/css/font-awesome.css",
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [ 
    "@/plugins/app",   
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    // '@nuxtjs/eslint-module',
    // https://go.nuxtjs.dev/stylelint
    // '@nuxtjs/stylelint-module',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/bootstrap
    // 'bootstrap-vue/nuxt',
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios', 
    // https://go.nuxtjs.dev/pwa
    '@nuxtjs/pwa',
    // https://go.nuxtjs.dev/content
    // '@nuxt/content',
    '@nuxtjs/proxy',
    '@nuxtjs/auth-next', 
     
  ],
  proxy: {
     "/api":"http://localhost:8000",
     "/v3":"https://api.flutterwave.com"
  },
  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
      proxy:true,
  },
  auth: { 
    redirect: {
      login: "/auth/signin",
      logout: "/auth/signin",
      home: "/dashboard",
      callback: "/callback"
    },
    strategies: {  
        'laravelJWT': {
          scheme: 'refresh',
          url: 'http://localhost:8000',
          endpoints: {
            login: { url: "/api/auth/signin", method: "post", propertyName: "access_token" }, 
            logout: { url: "/api/auth/signout", method: "post" },
            user: { url: "/api/auth/me", method: "get", propertyName: "user" },    
            refresh: { url: '/api/auth/refresh', method: 'post' },
          },
          token: {
            property: 'access_token',
            maxAge: 20160 * 60
          },
          refreshToken: {
            property: 'refresh_token',
            data: 'refresh_token',
            maxAge:20160 * 60
          } 
         
        }, 
    }
  },
  router: {
    middleware: ['auth']
  },
   

  // Content module configuration: https://go.nuxtjs.dev/config-content
  content: {},

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
