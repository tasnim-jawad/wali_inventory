import axios from "axios";
import { defineStore } from "pinia";

export const use_auth_store = defineStore("auth_store", {
    state: () => ({
        is_auth: 0,
        auth_info: {},
        role: {},
        user_unseen_notification: {}
    }),
    getters: {},
    actions: {
        set_is_auth: function (status) {
            this.is_auth = status;
        },
        log_out: async function () {
            await fetch("/api-logout", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            });
            window.sessionStorage.removeItem("prevurl");
            localStorage.removeItem("token");
            return (location.href = "/login");
        },
        check_is_auth: async function () {
            let that = this;
            // let res = await window.axios.get("/user/check_user");

            try {
                let res = await window.axios.get("/user/check_user");
                that.auth_info = res.data.user;
                that.is_auth = 1;

            } catch (error) {
                if (error.response && error.response.status === 401) {
                    location.href = "/login";
                } else {
                    console.error('An error occurred:', error);
                }
            }
            // if (res.status != 200) {
            //     console.log("dhukeche");
            //     localStorage.removeItem("token");
            //     return (location.href = "/login");
            // }
            // that.auth_info = res.data.user;
            // that.is_auth = 1;


            // that.role = res.data.user.roles[0];

            // console.log(res.data);
            // await window.cookieStore.get('AXRF-TOKEN')
            //     .then(async (cookie) => {
            //         if (!cookie) {
            //             this.log_out();
            //         }
            //         let token = `Bearer ${cookie.value}`;
            //         fetch("/api/v1/user", {
            //             method: "GET",
            //             headers: {
            //                 "Content-Type": "application/json",
            //                 "Authorization": token,
            //                 // 'Content-Type': 'application/x-www-form-urlencoded',
            //             },
            //         }).then(res => res.json())
            //             .then(res => {
            //                 this.set_is_auth(res.auth_status);
            //                 this.auth_info = res.auth_information;
            //             })
            //     })
        },
        
    },
});
