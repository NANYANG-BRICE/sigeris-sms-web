<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner col-md-6">
      <v-card class="auth-card">

        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link to="/" class="d-flex align-center">
            <v-img :src="require('@/assets/images/logos/logo.svg')" max-height="30px" max-width="30px" alt="logo" contain class="me-3 "></v-img>
            <h2 class="text-2xl font-weight-semibold">
              SIGERIS
            </h2>
          </router-link>
          <hr>
        </v-card-title>

        <!-- login form -->
        <v-card-text>
          <v-form @submit.prevent="Reinitialisation">
            <v-row>
              <v-col md="6" cols="12" >
                <span class="text-danger">{{msg_admin_username}}</span>
                <v-text-field 
                  :prepend-inner-icon="icons.mdiAccountHardHat"
                  v-model="admin_username"
                  outlined
                  label="Username"
                  placeholder="Nanyang Brice........"
                  hide-details
                  class="mb-3">
                </v-text-field>
              </v-col>

              <v-col md="6" cols="12" >
                <span class="text-danger">{{msg_admin_email}}</span>
                <v-text-field
                  :prepend-inner-icon="icons.mdiEmailCheckOutline"
                  v-model="admin_email"
                  outlined
                  label="Email"
                  placeholder="nanyangbrice@gmail.com........"
                  hide-details
                  :items="types"
                  class="mb-3">
                </v-text-field>
              </v-col>

              <v-col md="6" cols="12" >
                <span class="text-danger">{{msg_admin_password}}</span>
                <v-text-field
                  class="mb-3"
                  :prepend-inner-icon="icons.mdiLockAlertOutline"
                  v-model="admin_password"
                  outlined
                  :type="isPasswordVisible1 ? 'text' : 'password'"
                  label="Password"
                  placeholder="············"
                  :append-icon="isPasswordVisible1 ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                  hide-details
                  @click:append="isPasswordVisible1 = !isPasswordVisible1">
                </v-text-field>
              </v-col>

              <v-col md="6" cols="12" >
                <span class="text-danger">{{msg_admin_password}}</span>
                <v-text-field
                  class="mb-3"
                  :prepend-inner-icon="icons.mdiLockAlertOutline"
                  v-model="admin_password"
                  outlined
                  :type="isPasswordVisible ? 'text' : 'password'"
                  label="Confirm Password"
                  placeholder="············"
                  :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                  hide-details
                  @click:append="isPasswordVisible = !isPasswordVisible">
                </v-text-field>
              </v-col>

              <v-col md="12" cols="12" >
                <span class="text-danger">{{msg_admin_type}}</span>
                <v-select :prepend-inner-icon="icons.mdiBookOpenVariant" v-model="admin_type" outlined label="Fonction" :items="types" ></v-select>
              </v-col>
            </v-row>
              

            <div class="d-flex align-center justify-space-between flex-wrap">
              <v-checkbox label="Je le souhaite réélement !" v-model='checkbox' hide-details class="me-3 mt-1"> </v-checkbox>

              <!-- forgot link -->
              <router-link :to="{name:'pages-register'}">
                <a href="javascript:void(0)" class="mt-1">
                  J'ai pas de compte ?
                </a>
              </router-link>
              
            </div>

            <v-btn type="submit" block color="primary" class="mt-6 fw-bold"> 
              Réinitialier
            </v-btn>
          </v-form>
        </v-card-text>

        <!-- create new account  -->
        <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <span class="me-2">
            J'ai pas de problèmes !
          </span>
          <router-link :to="{name:'pages-login'}">
            S'authentifier
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
  import { mdiEyeOutline, mdiEyeOffOutline, mdiAccountHardHat, mdiEmailCheckOutline, mdiLockAlertOutline, mdiBookOpenVariant } from '@mdi/js'
  import { ref } from '@vue/composition-api'
  import Swal from 'sweetalert2'
  import axios from "axios";
  import {useRouter} from "vue-router";


  export default {
    setup() {
      const isPasswordVisible = ref(false)
      const isPasswordVisible1 = ref(false)
      const checkbox = ref(true)
      const socialLink = [
      ]

      const types = [
        'Etudiant', 
        'Enseignant',
        'Administrateur', 
      ]

      return {
        isPasswordVisible,
        isPasswordVisible1,
        checkbox,
        socialLink,
        types,

        icons: {
          mdiEyeOutline,
          mdiEyeOffOutline,
          mdiAccountHardHat,
          mdiEmailCheckOutline,
          mdiLockAlertOutline,
          mdiBookOpenVariant,
        },
      }
    },

    data () {
      return {
        admin_username: "",
        admin_email: "",
        admin_password: "",
        admin_type: "",

        msg_admin_username: "",
        msg_admin_email: "",
        msg_admin_password: "",
        msg_admin_type: "",
      };
    },

    methods: {
      async Reinitialisation() {
        try{
          const response =  await axios.post("Recover", {
            admin_username: this.admin_username,
            admin_email:    this.admin_email,
            admin_password: this.admin_password,
            admin_type:     this.admin_type,
          });
          (this.admin_username= ""),
          (this.admin_email= ""),
          (this.admin_password= ""),
          (this.admin_type= ""),

          console.log(response.data);
          if (response.data.error === true) {
            Swal.fire({
              backdrop:true, 
              allowOutsideClick: false,
              confirmButtonText: "Je comprend !",
              icon: 'error',
              title: 'Failed !',
              text: 'Authentification refusée veillez rééseiller...',
              timer: 15000,
            })

            if(response.data.msg.admin_username) {
              this.msg_admin_username = response.data.msg.admin_username
            }
            if(response.data.msg.admin_email) {
              this.msg_admin_email = response.data.msg.admin_email
            }
            if(response.data.msg.admin_password) {
              this.msg_admin_password = response.data.msg.admin_password
            }
            if(response.data.msg.admin_type) {
              this.msg_admin_type = response.data.msg.admin_type 
            }
            console.log(response.data.msg.admin_email);
          }
          else{
            this.$router.push("/");
            Swal.fire({
              width: 340,
              toast: true,
              timer: 5000,
              icon : 'success',
              position: 'top-end',
              showConfirmButton: false,
              title : 'Félicitations',
              text: 'Connexion établie.',
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
