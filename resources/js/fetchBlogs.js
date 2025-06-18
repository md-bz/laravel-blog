async function getBlogs() {
 try {
        const response = await fetch('/api/blog');
        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
        const json = await response.json();
        return json.data;
    } catch (error) {
        console.error('Failed to fetch blogs:', error);
        return [];
    }
}

function showBlogs (blogs){
    const list = document.getElementById('blogs')
    blogs.forEach(blog => {
        const li = document.createElement('li')
        const h = document.createElement('h4')
        const p = document.createElement('p')

        p.innerText = blog.content
        h.innerText = blog.title;
        li.appendChild(h);
        li.appendChild(p);
        list.appendChild(li)
    })
}

async function initBlogList (){
    const blogs = await getBlogs()
    console.log(blogs);
    
    showBlogs(blogs)
}
document.addEventListener('DOMContentLoaded', () => {
    initBlogList()}
);
