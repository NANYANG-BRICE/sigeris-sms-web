<template>
    <div class="action-buttons">
        <v-row justify="space-around">
            <v-col cols="auto" class="container">

                <v-dialog v-model="dialog" width="800" >
                    <template v-slot:activator="{ on, attrs }">
                        <Tooltip :tooltipText="'Consulter'">
                            <button class="" v-bind="attrs" v-on="on" open-on-focus="true" @click="handleAction('view')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </Tooltip>
                    </template>
                    <v-card>
                        <v-card-title class="text-h5 grey lighten-2">
                            Informations : <span class="mx-4">{{msg_admin_fullname}}</span>
                        </v-card-title>
                        <v-divider></v-divider>

                        <v-card-text class="mt-3">
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Matricule : <span class="mx-4">{{msg_admin_matricule}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Username : <span class="mx-2">{{msg_admin_username}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Email : <span class="mx-10">{{msg_admin_email}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Password : <span class="mx-3">{{msg_admin_password}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Firstname : <span class="mx-3">{{msg_admin_firstname}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Lastname : <span class="mx-4">{{msg_admin_lastname}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Tel Orange : <span class="mx-2">{{msg_admin_contact1}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Tel MTN : <span class="mx-7">{{msg_admin_contact2}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Statut : <span class="mx-10">{{msg_admin_statut}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Privilèges : <span class="mx-4">{{msg_admin_privileges}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Create as : <span class="mx-4">{{msg_admin_create_as}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Update as : <span class="mx-4">{{msg_admin_update_as}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" elevation="7" block @click="dialog = false" >
                                Fermer
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <Tooltip :tooltipText="'Réactiver'">
                    <button class="btn btn-outline text-danger mlf" @click="handleAction('refresh')">
                        <i class="fa fa-refresh text-primary" aria-hidden="true"></i>
                    </button>
                </Tooltip>
            </v-col>
        </v-row>
    </div>
</template>


<script>

    import { ref } from '@vue/composition-api';
    import Tooltip from "../../../../components/Tooltip.vue";
    import Swal from 'sweetalert2';
    import axios from "axios";
    import {useRouter} from "vue-router";

    export default {
        name: "ActionButtons",
        components: {
            Tooltip,
        },
        data(){
            return {
                e1: 1,
                dialog: false,
                dialog1: false,
                msg_admin_fullname: "",     
                msg_admin_matricule: "",
                msg_admin_username: "",
                msg_admin_email: "",
                msg_admin_password: "",
                msg_admin_firstname: "",
                msg_admin_lastname: "",
                msg_admin_contact1: "",
                msg_admin_contact2: "",
                msg_admin_statut: "",
                msg_admin_privileges: "",
                msg_admin_create_as: "",
                msg_admin_update_as: "",

                id_admin: "",     
                admin_username: "",     
                admin_email: "",
                admin_password: "",
                admin_firstname: "",
                admin_lastname: "",
                admin_contact1: "",
                admin_contact2: "",
                admin_privileges: "",

                privileges: [
                    'foo', 
                    'bar', 
                    'fizz', 
                    'buzz'
                ],
            }
        },
        methods: {
            handleAction(actionName) {
                if (actionName == 'refresh') {
                    console.log('réactivation en cours')
                    Swal.fire({
                        title: 'Reactive ?',
                        text: "Réactiver le compte de l\'administrateur "+this.data.admin_lastname+" "+this.data.admin_firstname,
                        icon: 'warning',
                        backdrop:true, 
                        allowOutsideClick: false,
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Continuer',
                        denyButtonText: `Annuler`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            try {
                                axios.get(`Enable_admin/`+this.data.id_admin);
                                Swal.fire({
                                    backdrop:true, 
                                    allowOutsideClick: false,
                                    timer: 15000,
                                    icon : 'success',
                                    title : 'Félicitations !',
                                    confirmButtonText: 'Continuer',
                                    text: 'L \'administrateur '+this.data.admin_lastname+" "+this.data.admin_firstname+' a vue son compte réactivé .',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        this.$router.go();
                                    }
                                });
                            } 
                            catch (error) {
                                console.log(error);
                            }
                           // this.$router.push("/administrateur/listing-account")
                        }
                        else if (result.isDenied) {
                            Swal.fire({
                                backdrop:true, 
                                allowOutsideClick: false,
                                timer: 15000,
                                icon : 'error',
                                title : 'Failed !',
                                confirmButtonText: 'Continuer',
                                text: 'Impossibilité de réactiver le compte l\'administrateur '+this.data.admin_lastname+" "+this.data.admin_firstname+'.',
                            });
                        }
                    })
                }
                else {
                    console.log('lecture en cours');
                    console.log(this.data)
                    this.msg_admin_fullname = this.data.admin_lastname + " " + this.data.admin_firstname;
                    this.msg_admin_matricule = this.data.admin_matricule;
                    this.msg_admin_email = this.data.admin_email;
                    this.msg_admin_username = this.data.admin_username;
                    this.msg_admin_password = "****************";
                    this.msg_admin_firstname = this.data.admin_firstname;
                    this.msg_admin_lastname = this.data.admin_lastname;
                    this.msg_admin_contact1 = this.data.admin_contact1;
                    this.msg_admin_contact2 = this.data.admin_contact2;
                    this.msg_admin_statut = this.data.admin_statut;
                    this.msg_admin_privileges = "****************";
                    this.msg_admin_create_as = "****************";
                    this.msg_admin_update_as =  "****************";
                }
            },

        },
        props: {
            data: {
                type: Object,
                required: true,
            },
        },
    };
</script>

<style>
    .text-danger {
        color: #dc3545 !important;
    }
    .text-dark {
        color: #000 !important;
    }

    .text-primary {
      color: #007bff !important;
    }

    .mlf{
        margin-left: 14px;
    }


    .invisible {
      visibility: hidden !important;
    }
</style>