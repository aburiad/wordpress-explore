<div id="posts"></div>
<script>
    const postsContainer = document.querySelector('#posts');
    fetch('http://v.local/wp-json/wp/v2/posts?per_page=3&orderBy=date&order=desc')
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
</script>
