<template>
    <v-container fluid fill-height>
        <v-row align="center" justify="center">
        <v-col cols="12" sm="12" md="10" lg="8">
            <v-card
            class="mx-2 pa-8"
            max-width="100%"
            outlined
            elevation="10"
            >
                <v-card-title>
                    <span
                        class="headline"
                        >Task List</span
                    >
                </v-card-title>
                <v-card-text>
                    <v-container> 
                        <v-row>
                            <v-col
                                cols="9"
                            >
                                <v-text-field
                                    v-model="txtsearch"
                                    label="Search Title"
                                    variant="outlined"
                                    density="compact"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="3"
                            >
                                <v-btn color="darkblue" @click="btnpopupadd('New')">
                                    Add Task
                                </v-btn>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col
                                v-for="task in filteredTasks"
                                :key="task.id"
                                cols="12"
                                sm="6"
                                md="4"
                                lg="4"
                                class="d-flex"
                            >
                                <v-card class="w-100" outlined>
                                    <v-card-title class="font-bold">
                                        {{ task.title }}
                                    </v-card-title>
                                    <v-card-text>
                                        <div class="mb-2" v-html="formatDescription(task.description)"></div>
                                        <div class="font-semibold">
                                        Status: 
                                        <v-chip variant="outlined" :color="getStatusColor(task.status)">
                                            {{ task.status }}
                                        </v-chip>
                                        </div>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn
                                        color="success"
                                        variant="text"
                                        @click="handleMarkDone(task.id)"
                                        :disabled="task.status === 'completed'"
                                        aria-label="Mark as done"
                                        tabindex="0"
                                        >
                                        Done
                                        </v-btn>
                                        <v-btn
                                        color="primary"
                                        variant="text"
                                        @click="btnpopupadd(task.id)"
                                        aria-label="Edit task"
                                        tabindex="0"
                                        >
                                        Edit
                                        </v-btn>
                                        <v-btn
                                        color="error"
                                        variant="text"
                                        @click="handleDelete(task.id)"
                                        aria-label="Delete task"
                                        tabindex="0"
                                        >
                                        Delete
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>

            
            
            </v-card>
        </v-col>
        </v-row>
    </v-container>

    <!-- show popup task -->
    <v-dialog v-model="dialogAdd" max-width="500px">
        <v-card>
            <v-card-title class="headline">{{ form.t_type }} 
                <v-chip variant="outlined" :color="getStatusColor(form.t_status)">
                    {{ form.t_status}}
                </v-chip>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col class="py-0">
                        <v-text-field
                            v-model="form.t_title"
                            label="Title"
                            type="text"
                            variant="outlined"
                            density="compact"
                            required
                            :error="v$.form.t_title.$error"
                            :error-messages="v$.form.t_title.$error ? ['This fill is required'] : []"
                            @blur="v$.form.t_title.$touch"
                        ></v-text-field>
                        <!-- <div v-if="v$.form.t_title.$error">Name field has an error.</div> -->
                    </v-col>
                </v-row>
                <v-row>
                    <v-col class="py-0">
                       <v-textarea 
                        v-model="form.t_description"
                        label="Description" 
                        variant="outlined"></v-textarea>
                    </v-col>
                </v-row>
                
            </v-card-text>
            <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="success"
                        text
                        @click="SaveOrUpdateAds"
                    >
                        {{ form.t_text_button }}
                    </v-btn>
                        <v-btn
                        color="gray"
                        text 
                        @click="dialogAdd = false"
                    >
                        Cancel
                    </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'

export default {
setup: () => ({ v$: useVuelidate() }),
data() {
    return {
      tasklist: [],
      form: {
        t_type: null,
        t_id: 0,
        t_title: null,
        t_description: null,
        t_status: null,
        t_text_button: null
      },
      txtsearch: "",
      dialogAdd: false,
      titleTouched: false,
      titleError: null
    };
  },
  validations () {
    return {
      form: {
        t_title: { required } 
      }
    }
  },
  created() {
        this.getListTask();
  },
  methods: {
    getListTask() {

        axios.get('/api/task',{
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token_id')}`
            }
        })
        .then(response => this.tasklist = response.data)
        .catch(error => console.log(error))
    },
    getStatusColor(status) {
        if (status === 'completed') return 'success';
        if (status === 'pending') return 'warning';
        return 'primary';
    },
    btnpopupadd(id){
        var self =this;

         this.v$.form.$reset();

        if(id === 'New'){
            self.form.t_type = "New Task";
            self.form.t_title = "";
            self.form.t_description = "";
            self.form.t_status = "pending";
            self.form.t_text_button = "Save";

            self.dialogAdd = true;
        }else{
            const task = self.tasklist.find(item => item.id === id);

            self.form.t_type = "Edit Task";
            self.form.t_title = task.title;
            self.form.t_description = task.description;
            self.form.t_status = task.status;
            self.form.t_text_button = "Update";
            self.form.t_id = task.id,


            self.dialogAdd = true;
        }
    },
    async SaveOrUpdateAds(){
        var self = this;

        const isFormCorrect = await this.v$.form.$validate()
        if (!isFormCorrect) return

        if(self.form.t_text_button === 'Save'){
            self.dialogAdd = false;
            Swal.fire({
                title: "Do you want to save?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/task', {
                        title: self.form.t_title,
                        description: self.form.t_description,
                        status: "pending"
                    }, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token_id')}`
                        }
                    })
                        .then(response => {
                            
                            self.dialogAdd = false;
                            self.getListTask();

                            Swal.fire({
                                title: "Save!",
                                text: "Your task has been saved.",
                                icon: "success"
                            });
                        })
                        .catch(error => console.log(error))
                    
                }else{
                     self.dialogAdd = true;
                }
            });

        }else{

            self.dialogAdd = false;
            Swal.fire({
                title: "Do you want to update?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.put(`/api/task/${self.form.t_id}`, {
                        title: self.form.t_title,
                        description: self.form.t_description
                    }, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token_id')}`
                        }
                    })
                        .then(response => {
                            
                            self.dialogAdd = false;
                            self.getListTask();

                            Swal.fire({
                                title: "Updated Successfully!",
                                text: "Your task has been updated.",
                                icon: "success"
                            });
                        })
                        .catch(error => console.log(error))
                    
                }else{
                     self.dialogAdd = true;
                }
            });
        }   

    },
    async handleDelete(id){
        var self = this;

        Swal.fire({
            title: "Do you want to delete?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/api/task/${id}`,{
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token_id')}`
                    }
                })
                    .then(response => {
                        self.getListTask();

                        Swal.fire({
                            title: "Deleted!",
                            text: "Your task has been deleted.",
                            icon: "success"
                        });
                    })
                    .catch(error => console.log(error))
                
            }
        });
    },
    async handleMarkDone(id){
        var self = this;

        Swal.fire({
            title: "Do you want to mark complete?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                axios.put(`/api/task/${id}`, {
                    status: 'completed'
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token_id')}`
                    }
                })
                .then(response => {
                    self.getListTask();

                    Swal.fire({
                        title: "Task Completed!",
                        text: "Your task has been completed.",
                        icon: "success"
                    });
                })
                .catch(error => console.log(error))
                
            }
        });
    },
    formatDescription(desc) {
        if (!desc) return '';
        return desc.replace(/\\n/g, '<br>').replace(/\n/g, '<br>');
    },
    
  },
  computed: {
    filteredTasks() {
        if (!this.txtsearch) return this.tasklist;
        return this.tasklist.filter(task =>
            task.title.toLowerCase().includes(this.txtsearch.toLowerCase())
        );
    }
  },
};
</script>
