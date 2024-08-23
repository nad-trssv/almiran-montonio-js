
// import jwt from 'jsonwebtoken';
import axios from 'axios';
import appService from "../../../services/appService";

export const frontendOrder = {
    namespaced: true,
    state: {
        lists: [],
        page: {},
        pagination: [],
        show: {},
        showTax: {},
        orderProducts: {},
        orderUser: {},
        orderAddress: {},
        outletAddress: {},
    },
    getters: {
        lists: function (state) {
            return state.lists;
        },
        pagination: function (state) {
            return state.pagination;
        },
        page: function (state) {
            return state.page;
        },
        show: function (state) {
            return state.show;
        },
        showTax: function (state) {
            return state.showTax;
        },
        orderProducts: function (state) {
            return state.orderProducts;
        },
        orderUser: function (state) {
            return state.orderUser;
        },
        orderAddress: function (state) {
            return state.orderAddress;
        },
        outletAddress: function (state) {
            return state.outletAddress;
        },
    },
    actions: {
        lists: function (context, payload) {
            return new Promise((resolve, reject) => {
                let url = `frontend/order`;
                if (payload) {
                    url = url + appService.requestHandler(payload.search);
                }
                axios.get(url).then((res) => {
                    if (typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit("lists", res.data.data);
                        if(typeof payload.search.paginate !== 'undefined' && payload.search.paginate === 1) {
                            context.commit("pagination", res.data);
                            context.commit("page", res.data.meta);
                        }
                    }

                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        save: function (context, payload) {
            return new Promise((resolve, reject) => {
                axios.post("/frontend/order", payload).then((res) => {

                    // const payload = {
                    //     "accessKey": "be550b78-bb18-4493-90b4-1dbed8e54b4d",
                    //     "merchantReference": "MY-ORDER-ID-123",
                    //     "returnUrl": "https://mystore.com/payment/return",
                    //     "notificationUrl": "https://mystore.com/payment/notify",
                    //     "currency": "EUR",
                    //     "grandTotal": 2.99,
                    //     "locale": "et",
                    //     "billingAddress": {
                    //         "firstName": "CustomerFirst",
                    //         "lastName": "CustomerLast",
                    //         "email": "customer@customer.com",
                    //         "addressLine1": "Kai 1",
                    //         "locality": "Tallinn",
                    //         "region": "Harjumaa",
                    //         "country": "EE",
                    //         "postalCode": "10111"
                    //     },
                    //     "shippingAddress": {
                    //         "firstName": "CustomerFirstShipping",
                    //         "lastName": "CustomerLastShipping",
                    //         "email": "customer@customer.com",
                    //         "addressLine1": "Kai 1",
                    //         "locality": "Tallinn",
                    //         "region": "Harjumaa",
                    //         "country": "EE",
                    //         "postalCode": "10111"
                    //     },
                    //     "lineItems": [
                    //         {
                    //             "name": "Hoverboard",
                    //             "quantity": 1,
                    //             "finalPrice": 99.99
                    //         }
                    //     ],
                    
                    //     // 2. Specify the payment method
                    //     "payment": {
                    //         "method": "paymentInitiation",
                    //         "methodDisplay": "Pay with your bank",
                    //         "methodOptions": {
                    //             "paymentDescription": "Payment for order 123",
                    //             "preferredCountry": "EE",
                    //             // This is the code of the bank that the customer chose at checkout. 
                    //             // See the GET /stores/payment-methods endpoint for the list of available banks.
                    //             "preferredProvider": "LHVBEE22"
                    //         },
                    //         "amount": 99.99, // Yes, this is the same as the grandTotal
                    //         "currency": "EUR" // This must match the currency of the order.
                    //     }
                    // }
                    
                    // // 3. Generate the token
                    // const token = jwt.sign(
                    //     payload, 
                    //     'uzq0TjYI7c0QbRWPOFb1IT3a93DSXIanQRYT4kM8iqIa',
                    //     { algorithm: 'HS256', expiresIn: '10m' }
                    // );
                    
                    // // console.log(token);
                    // // eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NLZXkiOiJNWV9BQ0NFU1NfS0VZIiwibWVyY2hhbnRSZWZlcmVuY2UiOiJNWS1PUkRFUi1JRC0xMjMiLCJyZXR1cm5VcmwiOiJodHRwczovL215c3RvcmUuY29tL3BheW1lbnQvcmV0dXJuIiwibm90aWZpY2F0aW9uVXJsIjoiaHR0cHM6Ly9teXN0b3JlLmNvbS9wYXltZW50L25vdGlmeSIsImN1cnJlbmN5IjoiRVVSIiwiZ3JhbmRUb3RhbCI6OTkuOTksImxvY2FsZSI6ImV0IiwiYmlsbGluZ0FkZHJlc3MiOnsiZmlyc3ROYW1lIjoiQ3VzdG9tZXJGaXJzdCIsImxhc3ROYW1lIjoiQ3VzdG9tZXJMYXN0IiwiZW1haWwiOiJjdXN0b21lckBjdXN0b21lci5jb20iLCJhZGRyZXNzTGluZTEiOiJLYWkgMSIsImxvY2FsaXR5IjoiVGFsbGlubiIsInJlZ2lvbiI6Ikhhcmp1bWFhIiwiY291bnRyeSI6IkVFIiwicG9zdGFsQ29kZSI6IjEwMTExIn0sInNoaXBwaW5nQWRkcmVzcyI6eyJmaXJzdE5hbWUiOiJDdXN0b21lckZpcnN0U2hpcHBpbmciLCJsYXN0TmFtZSI6IkN1c3RvbWVyTGFzdFNoaXBwaW5nIiwiZW1haWwiOiJjdXN0b21lckBjdXN0b21lci5jb20iLCJhZGRyZXNzTGluZTEiOiJLYWkgMSIsImxvY2FsaXR5IjoiVGFsbGlubiIsInJlZ2lvbiI6Ikhhcmp1bWFhIiwiY291bnRyeSI6IkVFIiwicG9zdGFsQ29kZSI6IjEwMTExIn0sImxpbmVJdGVtcyI6W3sibmFtZSI6IkhvdmVyYm9hcmQiLCJxdWFudGl0eSI6MSwiZmluYWxQcmljZSI6OTkuOTl9XSwicGF5bWVudCI6eyJtZXRob2QiOiJwYXltZW50SW5pdGlhdGlvbiIsIm1ldGhvZERpc3BsYXkiOiJQYXkgd2l0aCB5b3VyIGJhbmsiLCJtZXRob2RPcHRpb25zIjp7InBheW1lbnRSZWZlcmVuY2UiOiIxMDEwMTA5IiwicGF5bWVudERlc2NyaXB0aW9uIjoiUGF5bWVudCBmb3Igb3JkZXIgMTIzIiwicHJlZmVycmVkQ291bnRyeSI6IkVFIiwicHJlZmVycmVkUHJvdmlkZXIiOiJMSFZCRUUyMiJ9LCJhbW91bnQiOjk5Ljk5LCJjdXJyZW5jeSI6IkVVUiJ9LCJpYXQiOjE2NzYwNDQ3NTksImV4cCI6MTY3NjA0NTM1OX0.VichbCT2QQUBXE_yGNXAuYuXrwxrNELTHMDH7_dAPzw
                    
                    // axios.post('https://stargate.montonio.com/api/orders', {
                    //     data: token
                    // }).then(response => {
                    //     const { data } = response;
                    //     console.log(data.paymentUrl);
                    //     // https://gateway.montonio.com/some-random-uuid
                    
                    //     /**
                    //      * Note: After you have successfully created the order, 
                    //      * you may now pass the order.paymentUrl to the client-side.
                    //      */
                    
                    //     // 6. Redirect the customer to the checkout page (frontend)
                    //     // window.location.href = data.paymentUrl;
                    // });


                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        show: function (context, payload) {
            return new Promise((resolve, reject) => {
                axios.get(`frontend/order/show/${payload}`).then((res) => {
                    context.commit("show", res.data.data);
                    context.commit("orderProducts", res.data.data.order_products);
                    context.commit("orderUser", res.data.data.user);
                    context.commit("orderAddress", res.data.data.order_address);
                    context.commit("outletAddress", res.data.data.outlet_address);
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        changeStatus: function (context, payload) {
            return new Promise((resolve, reject) => {
                axios.post(`frontend/order/change-status/${payload.id}`,payload).then((res) => {
                    context.commit('show', res.data.data);
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
    },
    mutations: {
        lists: function (state, payload) {
            state.lists = payload
        },
        pagination: function (state, payload) {
            state.pagination = payload;
        },
        page: function (state, payload) {
            if (typeof payload !== "undefined" && payload !== null) {
                state.page = {
                    from: payload.from,
                    to: payload.to,
                    total: payload.total,
                };
            }
        },
        show: function (state, payload) {
            state.show = payload;
        },
        showTax: function (state, payload) {
            state.showTax = payload;
        },
        orderProducts: function (state, payload) {
            state.orderProducts = payload;
        },
        orderUser: function (state, payload) {
            state.orderUser = payload;
        },
        orderAddress: function (state, payload) {
            state.orderAddress = payload;
        },
        outletAddress: function (state, payload) {
            state.outletAddress = payload;
        },
    },
}
