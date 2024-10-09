
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// this styles is for the dark mode toggle
var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

// Change the icons inside the button based on previous settings
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
} else {
    themeToggleDarkIcon.classList.remove('hidden');
}

var themeToggleBtn = document.getElementById('theme-toggle');

themeToggleBtn.addEventListener('click', function() {

    // toggle icons inside button
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }
    
});
//////////////////////////////////////////////////////////////////////////////////////



///Fetch user data
document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('authToken');

    if (!token) {
        // window.location.href = '/sign-in.html'; // Redirect if no token is found
    } else {
        var currentUser = localStorage.getItem('currentUser')
        currentUser = JSON.parse(currentUser)
        // Optionally, verify the token or fetch user details

        //put the infos some where in the page
        //on header
        document.getElementById('user_name').innerText = currentUser.full_name
        document.getElementById('user_email').innerText = currentUser.email

        const baseURL = 'http://localhost:8000/file/'; // Replace with your actual backend URL
        const profilePicPath = currentUser.profile_pic // Path from the object
        const profilePicURL = baseURL + profilePicPath;
         // Display the image on the frontend
        document.getElementById('profile_pic').src = profilePicURL;
        // alert(1)



    }
});