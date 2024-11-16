<?php

do_action( 'my_custom_action');
do_action( 'my_custom_action_body');
do_action( 'my_custom_action_footer');
do_action('my_custom_title','Facebook','Hello Facebook');



$modifiedResults = apply_filters('show_my_name','riad');
echo $modifiedResults;
?>


<!-- <div id="posts"></div>

<div id="filter-container">
    <label for="category-select">Filter by Category:</label>
    <select id="category-select">
        <option value="">Select a Category</option>

    </select>

    <label for="tag-select">Filter by Tag:</label>
    <select id="tag-select">
        <option value="">Select a Tag</option>

    </select>
</div>

<div id="posts-container">

</div>


<script>
    console.log(btoa('d:lsQgjMielNBJUsFPpwDGFIRi'));

    const createPost = () => {
        fetch('http://v.local/wp-json/wp/v2/posts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Basic ' + btoa('d:lsQgjMielNBJUsFPpwDGFIRi')
            },
            body: JSON.stringify({
                title: 'test rest api',
                content: 'test content',
                status: 'publish'
            })
        })
            .then(response => {
                console.log('Response status:', response.status);  // This will show 401 or other HTTP status code
                return response.json();
            })
            .then(data => console.log('Data:', data))
            .catch(error => console.error('Error:', error));

    };

    
    createPost();


    const postsContainer = document.querySelector('#posts');
    // fetch('http://v.local/wp-json/wp/v2/posts?per_page=3&orderBy=date&order=desc')
    fetch('http://v.local/wp-json/wp/v2/posts?per_page=3&orderBy=date&order=desc&author=1&categories=35')
        .then(response => response.json())
        .then((data) => {
            mydata(data);
        })
        .catch(error => console.error('Error:', error));

    function mydata(data) {
        data.forEach((data) => {
            let title_tag = document.createElement('h2');
            title_tag.innerText = data.title.rendered
            postsContainer.append(title_tag)
        })
    }

    // from dropdown
    document.addEventListener("DOMContentLoaded", function () {
        const categorySelect = document.getElementById('category-select');
        const tagSelect = document.getElementById('tag-select');
        const postsContainer = document.getElementById('posts-container');

        // category and tag dropdown
        loadCategories();
        loadTags();

        // category tag load function
        function loadCategories() {
            fetch('http://v.local/wp-json/wp/v2/categories')
                .then(response => response.json())
                .then(categories => {
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                    });
                });
        }

        function loadTags() {
            fetch('http://v.local/wp-json/wp/v2/tags')
                .then(response => response.json())
                .then(tags => {
                    tags.forEach(tag => {
                        const option = document.createElement('option');
                        option.value = tag.id;
                        option.textContent = tag.name;
                        tagSelect.appendChild(option);
                    });
                });
        }

        // dropdown event listener add
        categorySelect.addEventListener('change', filterPosts);
        tagSelect.addEventListener('change', filterPosts);

        // filtered posts functin
        function filterPosts() {
            const categoryId = categorySelect.value;
            const tagId = tagSelect.value;

            // Query Parameters set
            let url = 'http://v.local/wp-json/wp/v2/posts?';
            if (categoryId) url += `categories=${categoryId}&`;
            if (tagId) url += `tags=${tagId}&`;

            // posts load
            fetch(url)
                .then(response => response.json())
                .then(posts => {
                    postsContainer.innerHTML = ''; // old post removed

                    // filtered post show
                    posts.forEach(post => {
                        const postElement = document.createElement('div');
                        postElement.innerHTML = `
                        <h2>${post.title.rendered}</h2>
                        <p>${post.excerpt.rendered}</p>
                    `;
                        postsContainer.appendChild(postElement);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    });

</script>

<?php

function wpe_get_endpoint_phrase()
{
    return ('Hello World, this is the WordPress REST API');
}

function wpe_register_example_routes()
{
    register_rest_route('hello-world/v1','test', array(
        'methods' => 'GET',
        'callback' => 'wpe_get_endpoint_phrase',
    ));
}

add_action('rest_api_init', 'wpe_register_example_routes');


?> 