<!DOCTYPE html>
<html lang="en"
      ng-app="socialSphereApp">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>SocialSphere - Social Media Feed Aggregator</title>

    <link rel="stylesheet"
          href="css/style.css">


    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>


<body ng-controller="FeedController">


<!-- =====================================================
     HEADER
===================================================== -->

<header class="header">


    <div class="logo">

        🌐

        <span>
            SocialSphere
        </span>

    </div>


    <!-- SEARCH -->

    <div class="search-box">

        <input type="text"
               placeholder="Search posts..."
               ng-model="searchText"
               ng-change="visiblePosts = 5">

        <button>
            🔍
        </button>

    </div>


    <!-- HEADER ACTIONS -->

    <div class="header-actions">

        <button class="icon-btn"
                ng-click="toggleNotifications()">

            🔔

            <span class="notification-badge">
                3
            </span>

        </button>


        <div class="profile">

            <div class="profile-avatar">
                A
            </div>

            <span>
                Abinaya
            </span>

        </div>

    </div>


    <!-- NOTIFICATION PANEL -->

    <div class="notification-panel"
         ng-if="notificationOpen">

        <h3>
            Notifications
        </h3>

        <div class="notification-item">
            ❤️ Your post received a new like.
        </div>

        <div class="notification-item">
            💬 Someone commented on a post.
        </div>

        <div class="notification-item">
            🔖 Your saved collection was updated.
        </div>

    </div>

</header>



<!-- =====================================================
     MAIN
===================================================== -->

<div class="main-container">


    <!-- =================================================
         LEFT SIDEBAR
    ================================================= -->

    <aside class="sidebar">

        <nav>


            <!-- HOME -->

            <a href=""
               class="nav-item"
               ng-class="{active: currentView === 'home'}"
               ng-click="goHome()">

                <span>🏠</span>

                <span>
                    Home
                </span>

            </a>


            <!-- EXPLORE -->

            <a href=""
               class="nav-item"
               ng-class="{active: currentView === 'explore'}"
               ng-click="goExplore()">

                <span>🔎</span>

                <span>
                    Explore
                </span>

            </a>


            <!-- SAVED -->

            <a href=""
               class="nav-item"
               ng-class="{active: currentView === 'saved'}"
               ng-click="goSaved()">

                <span>🔖</span>

                <span>
                    Saved
                </span>

            </a>


            <!-- SETTINGS -->

            <a href=""
               class="nav-item"
               ng-class="{active: currentView === 'settings'}"
               ng-click="goSettings()">

                <span>⚙️</span>

                <span>
                    Settings
                </span>

            </a>

        </nav>


        <!-- CONNECTION STATUS -->

        <div class="sidebar-bottom">

            <div class="connection-status">

                <span class="status-dot"></span>

                <div>

                    <strong>
                        All Sources
                    </strong>

                    <small>
                        Connected
                    </small>

                </div>

            </div>

        </div>

    </aside>



    <!-- =================================================
         FEED SECTION
    ================================================= -->

    <main class="feed-section">


        <!-- =================================================
             HOME
        ================================================= -->

        <section ng-if="currentView === 'home'">


            <!-- CATEGORY -->

            <div class="category-bar">

                <button class="category"
                        ng-class="{active: selectedCategory === 'All'}"
                        ng-click="filterCategory('All')">

                    All

                </button>


                <button class="category"
                        ng-class="{active: selectedCategory === 'Technology'}"
                        ng-click="filterCategory('Technology')">

                    💻 Technology

                </button>


                <button class="category"
                        ng-class="{active: selectedCategory === 'Education'}"
                        ng-click="filterCategory('Education')">

                    🎓 Education

                </button>


                <button class="category"
                        ng-class="{active: selectedCategory === 'Travel'}"
                        ng-click="filterCategory('Travel')">

                    ✈️ Travel

                </button>


                <button class="category"
                        ng-class="{active: selectedCategory === 'Entertainment'}"
                        ng-click="filterCategory('Entertainment')">

                    🎬 Entertainment

                </button>

            </div>



            <!-- FEED HEADER -->

            <div class="feed-header">

                <div>

                    <h1>
                        Latest Feed
                    </h1>

                    <p>
                        Discover posts from multiple sources
                    </p>

                </div>


                <button class="sort-btn"
                        ng-click="toggleSort()">

                    {{ sortType === 'latest' ? 'Latest' : 'Most Liked' }}

                    ▾

                </button>

            </div>



            <!-- LOADING -->

            <div class="loading"
                 ng-if="loading">

                <div class="spinner"></div>

                Loading posts...

            </div>



            <!-- ERROR -->

            <div class="error-message"
                 ng-if="error">

                Unable to load feed.

                <button onclick="location.reload()">
                    Retry
                </button>

            </div>



            <!-- =================================================
                 HOME POSTS
            ================================================= -->

            <article class="post-card"

                     ng-repeat="post in getVisiblePosts() track by post.id"

                     data-post-id="{{ post.id }}">


                <!-- POST HEADER -->

                <div class="post-top">

                    <div class="user-info">

                        <div class="avatar blue">

                            {{ post.username.charAt(0) }}

                        </div>


                        <div>

                            <h3>
                                {{ post.username }}
                            </h3>

                            <span>
                                {{ post.source }} Source · {{ post.time }}
                            </span>

                        </div>

                    </div>


                    <button class="more-btn">

                        •••

                    </button>

                </div>



                <!-- POST CONTENT -->

                <div class="post-content">

                    <span class="post-category"
                          ng-class="post.category.toLowerCase()">

                        {{ post.category }}

                    </span>


                    <h2>
                        {{ post.content }}
                    </h2>

                </div>



                <!-- ACTIONS -->

                <div class="post-actions">


                    <!-- LIKE -->

                    <button class="like-btn"

                            data-post-id="{{ post.id }}"

                            ng-class="{liked: post.userLiked}">

                        ❤️

                        <span>
                            {{ post.likes }}
                        </span>

                    </button>



                    <!-- COMMENT -->

                    <button class="comment-btn">

                        💬

                        <span>
                            {{ post.comments }}
                        </span>

                    </button>



                    <!-- SAVE -->

                    <button class="save-btn"

                            ng-click="toggleSave(post)"

                            ng-class="{saved: post.saved}">

                        🔖

                        <span>
                            {{ post.saved ? 'Saved' : 'Save' }}
                        </span>

                    </button>

                </div>



                <!-- =================================================
                     COMMENT BOX
                ================================================= -->

                <div class="comment-box">


                    <div class="comment-input-row">

                        <input type="text"

                               class="comment-input"

                               placeholder="Write a comment...">


                        <button class="comment-submit">

                            Post

                        </button>

                    </div>



                    <!-- =================================================
                         COMMENT LIST
                    ================================================= -->

                    <div class="comment-list">


                        <!-- NO COMMENTS -->

                        <p ng-if="!post.commentList ||
                                  post.commentList.length === 0">

                            No comments yet. Be the first to comment.

                        </p>



                        <!-- COMMENTS -->

                        <div class="comment-item"

                             ng-repeat="comment in post.commentList track by $index">


                            <strong>
                                {{ comment.username }}
                            </strong>


                            <p>
                                {{ comment.text }}
                            </p>


                        </div>


                    </div>

                </div>


            </article>



            <!-- LOAD MORE -->

            <div class="load-more"

                 ng-if="visiblePosts < getFilteredPosts().length">

                <span>
                    Scroll down to load more posts...
                </span>

            </div>



            <!-- ALL LOADED -->

            <div class="load-more"

                 ng-if="visiblePosts >= getFilteredPosts().length &&
                        getFilteredPosts().length > 0">

                <span>
                    All posts loaded ✓
                </span>

            </div>



            <!-- NO RESULTS -->

            <div class="empty-state"

                 ng-if="!loading &&
                        getFilteredPosts().length === 0">

                <div>
                    🔍
                </div>

                <h2>
                    No posts found
                </h2>

                <p>
                    Try another search or category.
                </p>

            </div>

        </section>



        <!-- =================================================
             EXPLORE
        ================================================= -->

        <section ng-if="currentView === 'explore'">


            <div class="feed-header">

                <div>

                    <h1>
                        Explore
                    </h1>

                    <p>
                        Discover posts from different categories
                    </p>

                </div>

            </div>



            <div class="category-bar">


                <button class="category"

                        ng-class="{active: exploreCategory === 'All'}"

                        ng-click="filterExplore('All')">

                    🌐 All

                </button>



                <button class="category"

                        ng-class="{active: exploreCategory === 'Technology'}"

                        ng-click="filterExplore('Technology')">

                    💻 Technology

                </button>



                <button class="category"

                        ng-class="{active: exploreCategory === 'Education'}"

                        ng-click="filterExplore('Education')">

                    🎓 Education

                </button>



                <button class="category"

                        ng-class="{active: exploreCategory === 'Travel'}"

                        ng-click="filterExplore('Travel')">

                    ✈️ Travel

                </button>



                <button class="category"

                        ng-class="{active: exploreCategory === 'Entertainment'}"

                        ng-click="filterExplore('Entertainment')">

                    🎬 Entertainment

                </button>

            </div>



            <article class="post-card explore-card"

                     ng-repeat="post in getVisiblePosts() track by post.id">


                <div class="post-top">

                    <div class="user-info">

                        <div class="avatar purple">

                            {{ post.username.charAt(0) }}

                        </div>


                        <div>

                            <h3>
                                {{ post.username }}
                            </h3>

                            <span>
                                {{ post.source }} Source · {{ post.time }}
                            </span>

                        </div>

                    </div>

                </div>



                <div class="post-content">

                    <span class="post-category"

                          ng-class="post.category.toLowerCase()">

                        {{ post.category }}

                    </span>


                    <h2>
                        {{ post.content }}
                    </h2>

                </div>



                <div class="explore-stats">

                    ❤️ {{ post.likes }}

                    &nbsp;&nbsp;

                    💬 {{ post.comments }}

                    &nbsp;&nbsp;

                    🔖 {{ post.saved ? 'Saved' : 'Save' }}

                </div>

            </article>



            <div class="empty-state"

                 ng-if="getFilteredPosts().length === 0">

                <div>
                    🔎
                </div>

                <h2>
                    Nothing to explore
                </h2>

                <p>
                    No posts are available in this category.
                </p>

            </div>

        </section>



        <!-- =================================================
             SAVED
        ================================================= -->

        <section ng-if="currentView === 'saved'">


            <div class="feed-header">

                <div>

                    <h1>
                        Saved Posts
                    </h1>

                    <p>
                        Your personal collection
                    </p>

                </div>

            </div>



            <article class="post-card"

                     data-post-id="{{ post.id }}"

                     ng-repeat="post in getVisiblePosts() track by post.id">


                <div class="post-top">

                    <div class="user-info">

                        <div class="avatar green">

                            {{ post.username.charAt(0) }}

                        </div>


                        <div>

                            <h3>
                                {{ post.username }}
                            </h3>

                            <span>
                                {{ post.source }} Source · {{ post.time }}
                            </span>

                        </div>

                    </div>

                </div>



                <div class="post-content">

                    <span class="post-category"

                          ng-class="post.category.toLowerCase()">

                        {{ post.category }}

                    </span>


                    <h2>
                        {{ post.content }}
                    </h2>

                </div>



                <div class="post-actions">

                    <button class="save-btn saved"

                            ng-click="toggleSave(post)">

                        🔖

                        <span>
                            Remove Saved
                        </span>

                    </button>

                </div>

            </article>



            <div class="empty-state"

                 ng-if="getFilteredPosts().length === 0">

                <div>
                    🔖
                </div>

                <h2>
                    No saved posts
                </h2>

                <p>
                    Save posts from your feed to see them here.
                </p>

                <button class="primary-btn"

                        ng-click="goHome()">

                    Explore Feed

                </button>

            </div>

        </section>



        <!-- =================================================
             SETTINGS
        ================================================= -->

        <section ng-if="currentView === 'settings'">


            <div class="feed-header">

                <div>

                    <h1>
                        Settings
                    </h1>

                    <p>
                        Manage your SocialSphere preferences
                    </p>

                </div>

            </div>



            <div class="settings-card">


                <div class="setting-row">

                    <div>

                        <strong>
                            Dark Mode
                        </strong>

                        <p>
                            Change the appearance of SocialSphere.
                        </p>

                    </div>


                    <button class="toggle-btn"

                            ng-class="{on: darkMode}"

                            ng-click="toggleDarkMode()">

                        {{ darkMode ? 'ON' : 'OFF' }}

                    </button>

                </div>



                <div class="setting-row">

                    <div>

                        <strong>
                            Data Source
                        </strong>

                        <p>
                            Four JSON-based social media sources are connected.
                        </p>

                    </div>


                    <span class="setting-status">

                        Connected

                    </span>

                </div>



                <div class="setting-row">

                    <div>

                        <strong>
                            XML Backup
                        </strong>

                        <p>
                            Aggregated feed can be converted into XML backup.
                        </p>

                    </div>


                    <button class="setting-link"

                            ng-click="createBackup()">

                        Create Backup

                    </button>

                </div>



                <div class="setting-row">

                    <div>

                        <strong>
                            XML Feed Viewer
                        </strong>

                        <p>
                            View the XML feed using XSLT transformation.
                        </p>

                    </div>


                    <button class="setting-link"

                            ng-click="openViewer()">

                        Open Viewer

                    </button>

                </div>



                <div class="setting-row danger-row">

                    <div>

                        <strong>
                            Clear Local Data
                        </strong>

                        <p>
                            Remove saved posts, likes and comments stored in this browser.
                        </p>

                    </div>


                    <button class="danger-btn"

                            ng-click="clearLocalData()">

                        Clear Data

                    </button>

                </div>

            </div>

        </section>

    </main>



    <!-- =================================================
         RIGHT SIDEBAR
    ================================================= -->

    <aside class="right-sidebar">


        <!-- TRENDING -->

        <section class="side-card">

            <h2>
                🔥 Trending
            </h2>


            <div class="trend"

                 ng-click="openTrending('AI')">

                <span>
                    #AI
                </span>

                <small>
                    Technology
                </small>

            </div>



            <div class="trend"

                 ng-click="openTrending('Technology')">

                <span>
                    #Technology
                </span>

                <small>
                    Technology feed
                </small>

            </div>



            <div class="trend"

                 ng-click="openTrending('Education')">

                <span>
                    #Education
                </span>

                <small>
                    Education feed
                </small>

            </div>



            <div class="trend"

                 ng-click="openTrending('Travel')">

                <span>
                    #Travel
                </span>

                <small>
                    Travel feed
                </small>

            </div>

        </section>



        <!-- SOURCES -->

        <section class="side-card">

            <h2>
                📡 Feed Sources
            </h2>



            <div class="source"

                 ng-click="openSource('Technology')">

                <span class="source-dot"></span>

                <div>

                    <strong>
                        Technology
                    </strong>

                    <small>
                        JSON Source
                    </small>

                </div>

            </div>



            <div class="source"

                 ng-click="openSource('Education')">

                <span class="source-dot"></span>

                <div>

                    <strong>
                        Education
                    </strong>

                    <small>
                        JSON Source
                    </small>

                </div>

            </div>



            <div class="source"

                 ng-click="openSource('Travel')">

                <span class="source-dot"></span>

                <div>

                    <strong>
                        Travel
                    </strong>

                    <small>
                        JSON Source
                    </small>

                </div>

            </div>



            <div class="source"

                 ng-click="openSource('Entertainment')">

                <span class="source-dot"></span>

                <div>

                    <strong>
                        Entertainment
                    </strong>

                    <small>
                        JSON Source
                    </small>

                </div>

            </div>

        </section>


    </aside>

</div>



<!-- =====================================================
     FOOTER
===================================================== -->

<footer>

    <p>
        © 2026 SocialSphere · Multi-Source Social Media Feed Aggregator
    </p>

</footer>



<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script src="angular/app.js"></script>

<script src="js/jquery-functions.js"></script>


</body>

</html>