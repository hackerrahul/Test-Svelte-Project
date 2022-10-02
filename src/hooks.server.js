export const handle = async ({ event, resolve }) => {
    const user_session = event.cookies.get('user')

    if (!user_session) {
        // if there is no session load page as normal
        // console.log(event.locals.user);
        return await resolve(event)
    }
    

    // fetch user based on access token
    const fetch_user = await fetch(import.meta.env.VITE_API_BASE_URL+"/fetch_user_details.php",{
        method:'GET',
        headers:{
            'X-Auth-Token':user_session
        }
    });

    
    const res = await fetch_user.json();
    // console.log(res);
    if(res.status == "success"){
        const user = res.data
        event.locals.user = {
            is_authenticated:true,
            name: user.name,
            email: user.email,
        }
    }

    return await resolve(event)

};
