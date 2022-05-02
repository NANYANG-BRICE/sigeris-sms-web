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
          <v-form @submit.prevent="Authentification">
            <span class="text-danger">{{msg_opt}}</span>
            <v-row>
              <v-col cols="12">
                <div class="ma-auto" style="max-width: 300px">
                  <v-otp-input
                  v-model="otp"
                  :length="length"
                  dark
                  ></v-otp-input>
                </div>
              </v-col>
            </v-row>
            <v-col cols="12">
              <v-btn type="submit" block :disabled="!isActive" color="primary" class="mt-6 fw-bold"> 
                Continuer 
              </v-btn>
            </v-col>
              
          </v-form>
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
  import { ref } from '@vue/composition-api'
  import Swal from 'sweetalert2'
  import axios from "axios";
  import {useRouter} from "vue-router";


  export default {
    data () {
      return {
        otp: "",
        length: 8,
        msg_otp: "",
      };
    },

    computed: {
      isActive () {
        return this.otp.length === this.length
      },
    },

    methods: {
      async Authentification() {
        try{
          const response =  await axios.post("SignIn", {
            otp: this.otp,
          });
          (this.otp= ""),

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
            if(response.data.msg.otp) {
              this.msg_otp = response.data.msg.otp
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
