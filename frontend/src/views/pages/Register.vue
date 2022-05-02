<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card class="auth-card">

        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link to="/" class="d-flex align-center">
            <v-img :src="require('@/assets/images/logos/logo.svg')" max-height="30px" max-width="30px" alt="logo" contain class="me-3 "></v-img>
            <h2 class="text-2xl font-weight-semibold">
              SIGERIS
            </h2>
          </router-link>
        </v-card-title>

        <!-- login form -->
        <v-card-text>
          <v-form @submit.prevent="Activation">
            <span class="text-danger">{{msg_matricule}}</span>
            <v-text-field
              :prepend-inner-icon="icons.mdiAccountHardHat"
              v-model="matricule"
              outlined
              autocomplete="off"
              label="Matricule"
              placeholder="DHTI-6048-5745-2002"
              hide-details
              class="mb-3">
            </v-text-field>

            <span class="text-danger">{{msg_token}}</span>
            <v-text-field
              :prepend-inner-icon="icons.mdiAccountDetailsOutline"
              v-model="token"
              outlined
              label="Personnal Token"
              placeholder="aLABbC0cEd1eDf2FghR(ddwvij4kYX....."
              hide-details
              class="mb-3">
            </v-text-field>

            <span class="text-danger">{{msg_password}}</span>
            <v-text-field
              class="mb-3"
              :prepend-inner-icon="icons.mdiLockAlertOutline"
              v-model="password"
              outlined
              :type="isPasswordVisible1 ? 'text' : 'password'"
              label="Password"
              placeholder="············"
              :append-icon="isPasswordVisible1 ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
              hide-details
              @click:append="isPasswordVisible1 = !isPasswordVisible1">
            </v-text-field>

            <span class="text-danger">{{msg_type}}</span>
            <v-select :prepend-inner-icon="icons.mdiBookOpenVariant" v-model="type" outlined label="Type de compte" :items="types" ></v-select>

            <div class="d-flex align-center justify-space-between flex-wrap">
              <v-checkbox label="Je souhaite continuer !" v-model='checkbox' hide-details class="me-3 mt-1"> </v-checkbox>

              <!-- forgot link -->
              <router-link :to="{name:'pages-recuver'}">
                <a href="javascript:void(0)" class="mt-1">
                  Password Oublié ?
                </a>
              </router-link>
              
            </div>

            <v-btn type="submit" block color="primary" class="mt-6 fw-bold"> 
              S'Initialiser
            </v-btn>
          </v-form>
        </v-card-text>

        <!-- create new account  -->
        <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <span class="me-2">
            J'ai déjà un compte actif ?
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
  import { mdiEyeOutline, mdiEyeOffOutline, mdiAccountHardHat, mdiAccountDetailsOutline, mdiEmailCheckOutline, mdiLockAlertOutline, mdiBookOpenVariant } from '@mdi/js'
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
          mdiBookOpenVariant,
          mdiLockAlertOutline,
          mdiEmailCheckOutline,
          mdiAccountDetailsOutline,
        },
      }
    },

    data () {
      return {
        type: "",
        token: "",
        password: "",
        matricule: "",

        msg_type: "",
        msg_token: "",
        msg_password: "",
        msg_matricule: "",
      };
    },

    methods: {
      async Activation() {
        try{
          const response =  await axios.post("Activate", {
            type:       this.type,
            token:      this.token,
            password:   this.password,
            matricule:  this.matricule,
          });
          (this.type = ""),
          (this.token = ""),
          (this.password = ""),
          (this.matricule = ""),

          console.log(response.data);
          if (response.data.error === true) {
            Swal.fire({
              backdrop:true, 
              allowOutsideClick: false,
              confirmButtonText: "Je comprend !",
              icon: 'error',
              title: 'Fatal Error !',
              text: 'Erreur servenue durant l\'activation du compte...',
              timer: 15000,
            })
            if(response.data.msg.type) {
              this.msg_type = response.data.msg.type
            }
            if(response.data.msg.token) {
              this.msg_token = response.data.msg.token
            }
            if(response.data.msg.password) {
              this.msg_password = response.data.msg.password
            }
            if(response.data.msg.matricule) {
              this.msg_matricule = response.data.msg.matricule
            }
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
