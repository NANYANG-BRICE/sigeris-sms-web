<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card class="auth-card">

        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link to="/" class="d-flex align-center">
            <v-img :src="require('@/assets/images/logos/logo.svg')" max-height="30px" max-width="30px" alt="logo" contain class="me-3 "></v-img>
            <h2 class="text-2xl font-weight-semibold">
              SIGERIS-SMS
            </h2>
          </router-link>
        </v-card-title>

       <!-- login form -->
        <v-card-text>
          <v-form @submit.prevent="Authentification">
            <span class="text-danger">{{msg_admin_username}}</span>
            <v-text-field
              :prepend-inner-icon="icons.mdiAccountHardHat"
              v-model="admin_username"
              outlined
              label="Username"
              placeholder="nanyangbrice@gmail.com"
              hide-details
              autocomplete="off"
              class="mb-3">
            </v-text-field>

            <span class="text-danger">{{msg_admin_password}}</span>
            <v-text-field
              :prepend-inner-icon="icons.mdiLockAlertOutline"
              v-model="admin_password"
              outlined
              :type="isPasswordVisible ? 'text' : 'password'"
              label="Password"
              placeholder="············"
              :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
              hide-details
              autocomplete="off"
              @click:append="isPasswordVisible = !isPasswordVisible">
            </v-text-field>

            <div class="d-flex align-center justify-space-between flex-wrap">
              <v-checkbox label="Se souvenir de moi" v-model='checkbox' hide-details class="me-3 mt-1"> </v-checkbox>

              <!-- forgot link -->
              <router-link :to="{name:'pages-recuver'}">
                <a href="javascript:void(0)" class="mt-1">
                  Password Oublié ?
                </a>
              </router-link>
              
            </div>

            <v-btn type="submit" block color="primary" class="mt-6 fw-bold"> 
              S'authentifier 
            </v-btn>
          </v-form>
        </v-card-text>

        <!-- create new account  -->
        <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <span class="me-2">
            J'ai un compte mais inactif ?
          </span>
          <router-link :to="{name:'pages-register'}">
            J'active
          </router-link>
        </v-card-text>
      </v-card>
    </div>

    <!-- background triangle shape  -->
    <img class="auth-mask-bg" height="173" :src="require(`@/assets/images/misc/mask-${$vuetify.theme.dark ? 'dark':'light'}.png`)" >

    <!-- tree -->
    <v-img class="auth-tree" width="247" height="185" src="@/assets/images/misc/tree.png" ></v-img>

    <!-- tree  -->
    <v-img class="auth-tree-3" width="377" height="289" src="@/assets/images/misc/tree-3.png" ></v-img>
  </div>
</template>

<script>
  import { mdiEyeOutline, mdiEyeOffOutline, mdiAccountHardHat, mdiLockAlertOutline  } from '@mdi/js'
  import { ref } from '@vue/composition-api'
  import Swal from 'sweetalert2'
  import axios from "axios";
  import {useRouter} from "vue-router";


  export default {
    setup() {
      const isPasswordVisible = ref(false)
      const isPasswordVisible1 = ref(false)
      const checkbox = ref(true)
      const socialLink = []

      return {
        isPasswordVisible,
        isPasswordVisible1,
        checkbox,
        socialLink,

        icons: {
          mdiEyeOutline,
          mdiEyeOffOutline,
          mdiAccountHardHat,
          mdiLockAlertOutline,
        },
      }
    },

    data () {
      return {
        admin_username: "",
        admin_password: "",
        msg_admin_username: "",
        msg_admin_password: "",
      };
    },

    methods: {
      async Authentification() {
        try{
          const response =  await axios.post("SignIn", {
            admin_username: this.admin_username,
            admin_password: this.admin_password,
          });
          (this.admin_username= ""),
          (this.admin_password= ""),

          console.log(response.data);

          if (response.data.error === true) {
            Swal.fire({
              icon:   response.data.icon,
              title:  response.data.title,
              text:   response.data.alert,
              timer:  response.data.timer,
              backdrop: true, 
              allowOutsideClick: false,
              confirmButtonText: "Continuer",
            })
            this.msg_admin_username = response.data.msg.admin_username;
            this.msg_admin_password = response.data.msg.admin_password;
          }
          else{
            this.$router.push("/dashboard");
            Swal.fire({
              icon:   response.data.icon,
              title:  response.data.title,
              text:   response.data.alert,
              timer:  response.data.timer,
              backdrop: true, 
              allowOutsideClick: false,
              confirmButtonText: "Continuer",
            });
          }
        }
        catch (error) {
          console.log(error);
        }
      },
    },
  }
</script>

<style lang="scss">
  @import '~@/plugins/vuetify/default-preset/preset/pages/auth.scss';
</style>

<style>
  .text-danger {
    color: #dc3545 !important;
  }
</style>
