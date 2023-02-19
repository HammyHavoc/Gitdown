<div class="wrap gitdown_ui" id="vue_app">
    <h1>Manage Git Articles</h1>

    <div style="display: flow-root;">
        <ul class='subsubsub'>
            <span style="color: hsl(0, 0%, 60%)">Published </span>
            {{ articles.filter(article => article._is_published).length }}
            <span style="color: hsl(0, 0%, 60%)"> out of </span>
            {{ articles.length }}
        </ul>
    </div>

    <br>

    <div>
        <button @click="updateAllArticles()" class="button button-primary">Update All</button>

        <button @click="deleteAll()" class="button">Delete All</button>

        <button @click="sync()" class="button">Reload</button>

        <a href="<?php echo esc_url(dirname(plugin_dir_url(__FILE__), 1) . '/files/example.zip') ?>" download="example" class="button">Download Example Folder Structure</a>

        <p class="search-box">
            <label class="screen-reader-text" for="post-search-input">Search Posts:</label>
            <input type="search" id="post-search-input" v-model="search_query" placeholder="Search" />
        </p>
    </div>

    <br>

    <table class="fixed wp-list-table widefat striped table-view-list posts">
        <thead>
            <tr>
                <th>Remote</th>
                <th>Wordpress</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in articles">
                <template v-if="item.remote.name.toLowerCase().includes(search_query.toLowerCase())">
                    <td>
                        <p class="row-title" title="Post Name">{{ item.remote.name }}</p>
                        <p title="Post Slug">{{ item.remote.slug }}</p>
                        <p title="description">{{ item.remote.description }}</p>
                        <p title="Category">{{ item.remote.category }}</p>
                    </td>
                    <td>
                        <template v-if="item._is_published">
                            <div class="row-title">✅ Is on Wordpress</div>

                            <br />

                            <div>ID: <code>{{ item.local.ID }}</code></div>
                            <div>Slug: <code>{{ item.local.post_name }}</code></div>
                            <div>Excerpt: <code>{{ item.local.post_excerpt }}</code></div>
                            <div>Status: <code>{{ item.local.post_status }}</code></div>
                            <br>
                            <div><a target="_blank" :href="item.local.guid">Open in new Tab</a></div>
                            <br>

                            <?php if (has_post_thumbnail($postData[GD_LOCAL_KEY]['ID'])) : ?>
                                <img src="" alt="Thumbnail not Found" style="max-width: 130px; filter: grayscale(50%); opacity: 0.5">
                            <?php endif; ?>
                        </template>
                    </td>
                    <td>
                        <div v-if="item._is_published">
                            <button class="button action button-primary" @click="updateArticle(item.remote.slug)">Update</button>
                            <button class="button action" @click="deleteArticle(item.remote.slug)">Delete</button>
                        </div>

                        <div v-else>
                            <button class="button action" @click="updateArticle(item.remote.slug)">Publish</button>
                        </div>

                        <br>

                        <div :ref="item.remote.slug" style="visibility: hidden; display: flex; align-items: center; font-weight: 600; font-size: 1rem;">
                            <img src="<?php echo GD_ROOT_URL . 'images/loader.svg' ?>" alt="Loader" style="width: 30px">
                            <span>Loading</span>
                        </div>
                    </td>
                </template>
            </tr>
        </tbody>
    </table>
</div>