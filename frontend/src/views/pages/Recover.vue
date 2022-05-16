<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner col-md-7">
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
                <span class="text-danger"><span class="invisible">.</span>{{msg_admin_matricule}}</span>
                <v-text-field 
                  :prepend-inner-icon="icons.mdiAccountHardHat"
                  v-model="admin_matricule"
                  outlined
                  label="Matricule"
                  placeholder="FKTS-2547-2478-2021."    
                  autocomplete="off"
                  hide-details>
                </v-text-field>
              </v-col>

              <v-col md="6" cols="12" >
                <span class="text-danger"><span class="invisible">.</span>{{msg_admin_email}}</span>
                <v-text-field
                  :prepend-inner-icon="icons.mdiEmailCheckOutline"
                  v-model="admin_email"
                  outlined
                  label="Email"
                  placeholder="nanyangbrice@gmail.com........"
                  autocomplete="off"
                  hide-details
                  :items="types">
                </v-text-field>
              </v-col>

              <v-col md="6" cols="12" >
                <span class="text-danger"><span class="invisible">.</span>{{msg_admin_password}}</span>
                <v-text-field
                  :prepend-inner-icon="icons.mdiLockAlertOutline"
                  v-model="admin_password"
                  outlined
                  :type="isPasswordVisible ? 'text' : 'password'"
                  label="Password"
                  placeholder="············"
                  :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                  autocomplete="off"
                  hide-details
                  @click:append="isPasswordVisible = !isPasswordVisible">
                </v-text-field>
              </v-col>

              <v-col md="6" cols="12" >
                <span class="text-danger"><span class="invisible">.</span>{{msg_admin_confirm_password}}</span>
                <v-text-field
                  :prepend-inner-icon="icons.mdiLockAlertOutline"
                  v-model="admin_confirm_password"
                  outlined
                  :type="isPasswordVisible1 ? 'text' : 'password'"
                  label="Confirm Password"
                  placeholder="············"
                  :append-icon="isPasswordVisible1 ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                  autocomplete="off"
                  hide-details
                  @click:append="isPasswordVisible1 = !isPasswordVisible1">
                </v-text-field>
              </v-col>

              <v-col md="12" cols="12" >
                <span class="text-danger"><span class="invisible">.</span>{{msg_admin_type}}</span>
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
  import { 
    mdiEyeOutline, 
    mdiEyeOffOutline, 
    mdiAccountHardHat, 
    mdiEmailCheckOutline, 
    mdiLockAlertOutline, 
    mdiBookOpenVariant, 
    mdiQrcode,
    mdiCodeJson,
  } from '@mdi/js';
  import { ref } from '@vue/composition-api';
  import Swal from 'sweetalert2';
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
          mdiQrcode,
          mdiCodeJson,
        },
      }
    },

    data () {
      return {
        admin_matricule: "",
        admin_email: "",
        admin_code_activation: "",
        admin_password: "",
        admin_confirm_password: "",
        admin_type: "",

        msg_admin_matricule: "",
        msg_admin_email: "",
        msg_admin_password: "",
        msg_admin_confirm_password: "",
        msg_admin_type: "",
      };
    },

    methods: {
      async Reinitialisation() {
        try{
          const response =  await axios.post("Recover", {
            admin_matricule:          this.admin_matricule,
            admin_email:              this.admin_email,
            admin_password:           this.admin_password,
            admin_confirm_password:   this.admin_confirm_password,
            admin_type:               this.admin_type,
          });
          (this.admin_matricule= ""),
          (this.admin_email= ""),
          (this.admin_password= ""),
          (this.admin_confirm_password= ""),
          (this.admin_type= ""),

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

            this.msg_admin_matricule        = response.data.msg.admin_matricule;
            this.msg_admin_email            = response.data.msg.admin_email;
            this.msg_admin_password         = response.data.msg.admin_password;
            this.msg_admin_confirm_password = response.data.msg.admin_confirm_password;
            this.msg_admin_type             = response.data.msg.admin_type;

            console.log(response.data.msg.admin_email);
          }
          else{
            this.$router.push("/pages/login");
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
  .invisible {
    visibility: hidden !important;
  }
</style>
