import { createStore } from 'vuex'

const store = createStore({

      state: {
            //define Variables
            token : localStorage.getItem('token') || 0,
            userInfo : localStorage.getItem('user_info'),
      },

      mutations: {
            //Update variable value
            UPDATE_TOKEN(state, payload){
                  state.token = payload
            },

            UPDATE_USER_INFO(state, userInfo){
                  state.userInfo = userInfo
            },
      },

      actions: {
            //action to be performed
            setToken(context, payload){
                  localStorage.setItem('token', payload)
                  context.commit('UPDATE_TOKEN', payload)
            },
            setUserInfo(context, userInfo) {
                  if (userInfo) {
                        localStorage.setItem('user_info', JSON.stringify(userInfo));
                  } else {
                        localStorage.removeItem('user_info');
                  }
                  context.commit('UPDATE_USER_INFO', userInfo);
            },
            removeUserInfo(context){
                  localStorage.removeItem('user_info');
                  context.commit('UPDATE_USER_INFO', 0);
            },
            removeToken(context){
                  localStorage.removeItem('token');
                  context.commit('UPDATE_TOKEN', 0);
            }
      },

      getters: {
            //get state variable value
            getToken: function (state){
                  return state.token
            },

            getUserInfo: function(state){
                  return state.userInfo
            },

            getUserId: function (state) {
                  try {
                        let userInfo = JSON.parse(state.userInfo);
                        return userInfo.auth_id;
                  } catch (error) {
                        console.error("Error parsing JSON data:", error);
                        return null;
                  }
            },

            getUserName: function(state){
                  let userInfo = JSON.parse(state.userInfo);
                  return userInfo.name
            },

            getUserData: function(state){
                  try {
                        let userInfo = JSON.parse(state.userInfo);
                        return userInfo?.userData;
                  }catch(error){
                        return null;
                  }
            },

            getUserimage: function(state){
                  let image = "";
                  try {
                        
                        let userInfo = JSON.parse(state.userInfo);
                        image = userInfo?.userData.image;
                        
                  } catch (error) {
                        console.log("🚀 ~ error:", error)                        
                  }

                  return image;
            },
      }
})

export default store;