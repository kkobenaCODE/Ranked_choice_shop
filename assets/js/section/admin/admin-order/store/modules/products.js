import {concatUrlByParams, getUrlProductsByCategory} from "../../../../../utils/url-generator";
import axios from "axios";
import {StatusCodes} from "http-status-codes";
import {apiConfig} from "../../../../../utils/settings";

const state = () => ({
    categories: [],
    categoryProducts:[],
    newOrderProduct: {
        categoryId: "",
        productId: "",
        quantity: "",
        pricePerOne: ""
    },
    staticStore: {
        orderId: window.staticStore.orderId,
        orderProducts: window.staticStore.orderProducts,

        url: {
            viewProduct: window.staticStore.urlViewProduct,
            apiOrderProduct: window.staticStore.urlAPIOrderProduct,
            apiCategory: window.staticStore.urlAPICategory ,
            apiProduct: window.staticStore.urlAPIProduct
        }
    },
    viewProductCountLimit: 25
});

const getters = {};

const actions = {
   async getProductsByCategory({commit , state}){
       const url =getUrlProductsByCategory(
           state.staticStore.url.apiProduct ,
           state.newOrderProduct.categoryId,
           1,
           state.viewProductCountLimit);
       const result = await axios.get(url, apiConfig);

       if (result.data && result.status === StatusCodes.OK) {
           commit('setCategoryProducts' , result.data["hydra:member"]);
       }
   },

   async getCategories({commit , state}){
        const url = state.staticStore.url.apiCategory;
        const result = await axios.get(url, apiConfig);

       if (result.data && result.status === StatusCodes.OK) {
           commit('setCategories' , result.data["hydra:member"]);
       }
    },

    async removeOrderProduct({state, dispatch}, orderProductId) {
        const url = concatUrlByParams(
            state.staticStore.url.apiOrderProduct,
            orderProductId);
        const result = await axios.delete(url, apiConfig);

        if (result.status === StatusCodes.NO_CONTENT) {
            console.log('Deleted');
        }
    }
};

const mutations = {
    setCategories(state , categories) {
        state.categories = categories;
    },
    setCategoryProducts(state , categoryProducts){
        state.categoryProducts = categoryProducts;
    },
    setNewProductInfo(state, formData) {
        state.newOrderProduct.categoryId = formData.categoryId;
        state.newOrderProduct.productId = formData.productId;
        state.newOrderProduct.quantity = formData.quantity;
        state.newOrderProduct.pricePerOne = formData.pricePerOne;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}