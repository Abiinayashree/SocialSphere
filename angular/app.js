var app = angular.module("socialSphereApp", []);

app.controller("FeedController", function ($scope, $http, $window, $timeout) {

    /* =====================================================
       BASIC VARIABLES
    ===================================================== */

    $scope.loading = true;
    $scope.error = false;

    $scope.posts = [];
    var INTERACTION_KEY = "socialSphereInteractions";

function getInteractionData() {
    try {
        return JSON.parse(
            localStorage.getItem(INTERACTION_KEY)
        ) || {};
    } catch (e) {
        return {};
    }
}

$scope.saveInteractionData = function () {

    var data = {};

    $scope.posts.forEach(function (post) {

        data[post.id] = {
            likes: Number(post.likes || 0),
            userLiked: !!post.userLiked,
            saved: !!post.saved,
            commentList: Array.isArray(post.commentList)
                ? post.commentList
                : []
        };

    });

    localStorage.setItem(
        INTERACTION_KEY,
        JSON.stringify(data)
    );
};


function restoreInteractionData() {

    var data = getInteractionData();

    $scope.posts.forEach(function (post) {

        post.originalLikes = Number(post.likes || 0);
        post.originalComments = Number(post.comments || 0);

        var savedData = data[String(post.id)];

        if (savedData) {

            post.likes = Number(
                savedData.likes
            );

            post.userLiked =
                !!savedData.userLiked;

            post.saved =
                !!savedData.saved;

            post.commentList =
                Array.isArray(savedData.commentList)
                    ? savedData.commentList
                    : [];

            post.comments =
                post.originalComments +
                post.commentList.length;

        } else {

            post.likes =
                post.originalLikes;

            post.userLiked = false;
            post.saved = false;
            post.commentList = [];

            post.comments =
                post.originalComments;
        }

    });
}

    $scope.searchText = "";
    $scope.selectedCategory = "All";

    $scope.visiblePosts = 5;

    $scope.currentView = "home";
    $scope.exploreCategory = "All";

    $scope.sortType = "latest";

    $scope.darkMode = false;
    $scope.notificationOpen = false;

    $scope.toastMessage = "";
    $scope.showToastBox = false;


    /* =====================================================
       TOAST MESSAGE
    ===================================================== */

    $scope.showToast = function (message) {

        $scope.toastMessage = message;
        $scope.showToastBox = true;

        $timeout(function () {

            $scope.showToastBox = false;

        }, 2500);

    };


    /* =====================================================
       LOAD POSTS FROM PHP
    ===================================================== */

    $http.get("api/aggregate.php")

        .then(function (response) {

            if (
                response.data &&
                response.data.success
            ) {

                /*
                   Always load fresh original data
                   from JSON files.
                */

                $scope.posts =
                    response.data.posts || [];


                /*
                   Temporary interaction states.
                   These are NOT saved to localStorage.
                */

                restoreInteractionData();

            } else {

                $scope.error = true;

            }

            $scope.loading = false;

        })

        .catch(function (error) {

            console.log(
                "Aggregate error:",
                error
            );

            $scope.error = true;
            $scope.loading = false;

        });


    /* =====================================================
       HOME
    ===================================================== */

    $scope.goHome = function (category) {

        $scope.currentView = "home";

        $scope.searchText = "";


        if (category) {

            $scope.selectedCategory =
                category;

        } else {

            $scope.selectedCategory =
                "All";

        }


        $scope.visiblePosts = 5;

        $scope.notificationOpen = false;

    };


    /* =====================================================
       EXPLORE
    ===================================================== */

    $scope.goExplore = function () {

        $scope.currentView = "explore";

        $scope.exploreCategory = "All";

        $scope.visiblePosts = 5;

        $scope.notificationOpen = false;

    };


    /* =====================================================
       SAVED
    ===================================================== */

    $scope.goSaved = function () {

        $scope.currentView = "saved";

        $scope.visiblePosts = 5;

        $scope.notificationOpen = false;

    };


    /* =====================================================
       SETTINGS
    ===================================================== */

    $scope.goSettings = function () {

        $scope.currentView = "settings";

        $scope.notificationOpen = false;

    };


    /* =====================================================
       HOME CATEGORY FILTER
    ===================================================== */

    $scope.filterCategory = function (category) {

        $scope.currentView = "home";

        $scope.selectedCategory =
            category;

        $scope.searchText = "";

        $scope.visiblePosts = 5;

    };


    /* =====================================================
       EXPLORE CATEGORY FILTER
    ===================================================== */

    $scope.filterExplore = function (category) {

        $scope.exploreCategory =
            category;

        $scope.visiblePosts = 5;

    };


    /* =====================================================
       LIKE
       TEMPORARY ONLY
    ===================================================== */

    $scope.handleLike = function (postId) {

        var post =
            $scope.posts.find(function (item) {

                return (
                    String(item.id) ===
                    String(postId)
                );

            });


        if (!post) {

            console.log(
                "Post not found:",
                postId
            );

            return;

        }


        if (post.userLiked) {

            /*
               Unlike
            */

            post.likes =
                Math.max(
                    0,
                    Number(post.likes) - 1
                );

            post.userLiked = false;

            $scope.showToast(
                "Like removed"
            );

        } else {

            /*
               Like
            */

            post.likes =
                Number(post.likes) + 1;

            post.userLiked = true;

            $scope.showToast(
                "Post liked ❤️"
            );

        }

        $scope.saveInteractionData();

    };


    /* =====================================================
       COMMENT
       TEMPORARY ONLY
    ===================================================== */

    $scope.addComment = function (postId, commentText) {

        var post = $scope.posts.find(function (p) {
            return String(p.id) === String(postId);
        });

        if (!post || !commentText) {
            return;
        }

        if (!post.commentList) {
            post.commentList = [];
        }

        post.commentList.push({
            username: "You",
            text: commentText
        });

        post.comments =
            Number(post.originalComments || 0) +
            post.commentList.length;

        $scope.saveInteractionData();

        alert("Comment posted successfully");
    };
    /* =====================================================
       SAVE / UNSAVE
       TEMPORARY ONLY
    ===================================================== */

    $scope.toggleSave = function (post) {

        post.saved = !post.saved;

        $scope.saveInteractionData();
    };


    /* =====================================================
       TRENDING
    ===================================================== */

    $scope.openTrending =
        function (trend) {

            $scope.currentView =
                "home";

            $scope.visiblePosts = 5;


            if (trend === "AI") {

                $scope.selectedCategory =
                    "Technology";

                $scope.searchText =
                    "Artificial Intelligence";

            } else {

                $scope.selectedCategory =
                    trend;

                $scope.searchText = "";

                $scope.showToast(
                    "#" +
                    trend +
                    " feed opened"
                );

            }

        };


    /* =====================================================
       FEED SOURCES
    ===================================================== */

    $scope.openSource =
        function (source) {

            $scope.currentView =
                "home";

            $scope.selectedCategory =
                source;

            $scope.searchText = "";

            $scope.visiblePosts = 5;

            $scope.showToast(
                source +
                " source opened"
            );

        };


    /* =====================================================
       SEARCH
    ===================================================== */

    $scope.onSearch = function () {

        $scope.visiblePosts = 5;

    };


    /* =====================================================
       SORT
    ===================================================== */

    $scope.toggleSort =
        function () {

            if (
                $scope.sortType ===
                "latest"
            ) {

                $scope.sortType =
                    "popular";

            } else {

                $scope.sortType =
                    "latest";

            }


            $scope.visiblePosts = 5;

        };


    /* =====================================================
       FILTERED POSTS
    ===================================================== */

    $scope.getFilteredPosts =
        function () {

            var result = [];


            angular.forEach(
                $scope.posts,
                function (post) {

                    var matchesSearch =
                        true;

                    var matchesCategory =
                        true;

                    var matchesView =
                        true;


                    /* -----------------------------
                       SEARCH
                    ----------------------------- */

                    if (
                        $scope.searchText &&
                        $scope.searchText
                            .trim() !== ""
                    ) {

                        var search =
                            $scope.searchText
                                .toLowerCase()
                                .trim();


                        var text =
                            (
                                post.username +
                                " " +
                                post.content +
                                " " +
                                post.category +
                                " " +
                                post.source
                            ).toLowerCase();


                        matchesSearch =
                            text.indexOf(
                                search
                            ) !== -1;

                    }


                    /* -----------------------------
                       HOME CATEGORY
                    ----------------------------- */

                    if (
                        $scope.currentView ===
                            "home" &&
                        $scope.selectedCategory !==
                            "All"
                    ) {

                        matchesCategory =
                            post.category ===
                            $scope.selectedCategory;

                    }


                    /* -----------------------------
                       EXPLORE CATEGORY
                    ----------------------------- */

                    if (
                        $scope.currentView ===
                            "explore" &&
                        $scope.exploreCategory !==
                            "All"
                    ) {

                        matchesCategory =
                            post.category ===
                            $scope.exploreCategory;

                    }


                    /* -----------------------------
                       SAVED
                    ----------------------------- */

                    if (
                        $scope.currentView ===
                            "saved"
                    ) {

                        matchesView =
                            post.saved === true;

                    }


                    if (
                        matchesSearch &&
                        matchesCategory &&
                        matchesView
                    ) {

                        result.push(post);

                    }

                }
            );


            /* -----------------------------
               SORT
            ----------------------------- */

            if (
                $scope.sortType ===
                "popular"
            ) {

                result.sort(
                    function (a, b) {

                        return (
                            Number(b.likes) -
                            Number(a.likes)
                        );

                    }
                );

            }


            return result;

        };


    /* =====================================================
       VISIBLE POSTS
    ===================================================== */

    $scope.getVisiblePosts =
        function () {

            var filtered =
                $scope.getFilteredPosts();


            return filtered.slice(
                0,
                $scope.visiblePosts
            );

        };


    /* =====================================================
       LOAD MORE
    ===================================================== */

    $scope.loadMore = function () {

        var total =
            $scope.getFilteredPosts()
                .length;


        if (
            $scope.visiblePosts <
            total
        ) {

            $scope.visiblePosts += 5;

        }

    };


    /* =====================================================
       INFINITE SCROLL
    ===================================================== */

    angular.element($window).on(
        "scroll",
        function () {

            var windowHeight =
                $window.innerHeight;

            var scrollTop =
                $window.pageYOffset;

            var documentHeight =
                document.documentElement
                    .scrollHeight;


            if (
                windowHeight +
                scrollTop >=
                documentHeight - 180
            ) {

                $scope.$applyAsync(
                    function () {

                        $scope.loadMore();

                    }
                );

            }

        }
    );


    /* =====================================================
       NOTIFICATIONS
    ===================================================== */

    $scope.toggleNotifications =
        function () {

            $scope.notificationOpen =
                !$scope.notificationOpen;

        };


    /* =====================================================
       DARK MODE
    ===================================================== */

    var savedDarkMode =
        localStorage.getItem(
            "socialSphereDarkMode"
        );


    if (
        savedDarkMode === "true"
    ) {

        $scope.darkMode = true;

    }


    $scope.toggleDarkMode =
        function () {

            $scope.darkMode =
                !$scope.darkMode;


            localStorage.setItem(
                "socialSphereDarkMode",
                $scope.darkMode
            );


            document.body.classList.toggle(
                "dark-mode",
                $scope.darkMode
            );


            $scope.showToast(
                $scope.darkMode
                    ? "Dark Mode enabled 🌙"
                    : "Light Mode enabled ☀️"
            );

        };


    /* =====================================================
       CREATE XML BACKUP
    ===================================================== */

    $scope.createBackup = function () {

        $http.get("api/backup.php")
            .then(function (response) {

                if (response.data && response.data.success) {

                    alert(
                        response.data.message +
                        "\nTotal Posts: " +
                        response.data.total_posts
                    );

                } else {

                    alert("Backup failed!");

                }

            })
            .catch(function (error) {

                console.log("Backup Error:", error);

                alert(
                    "Backup failed. Check console."
                );

            });

    };


    /* =====================================================
       OPEN XML VIEWER
    ===================================================== */

    $scope.openViewer =
        function () {

            $window.open(
                "xml-viewer.php",
                "_blank"
            );

        };


    /* =====================================================
       CLEAR LOCAL DATA
    ===================================================== */

    $scope.clearLocalData = function () {

        localStorage.removeItem(
        "socialSphereInteractions"
        );

        location.reload();
    };


    /* =====================================================
       INITIAL DARK MODE
    ===================================================== */

    if ($scope.darkMode) {

        document.body.classList.add(
            "dark-mode"
        );

    }

});