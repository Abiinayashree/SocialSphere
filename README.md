# 🌐 SocialSphere – Social Media Feed Aggregator

SocialSphere is a web-based **Social Media Feed Aggregator** that collects and displays posts from multiple social-media-like JSON sources in a single, user-friendly feed.

The project demonstrates the integration of **PHP, AngularJS, jQuery, JSON, XML, and XSLT** to create a dynamic and responsive web application.

## ✨ Features

* 📱 Responsive social media feed
* 🔍 Search posts
* 🏷️ Category-based filtering
* ❤️ Like posts
* 💬 Add comments
* 🔖 Save / unsave posts
* 📌 View saved posts
* 🔄 Infinite scroll / Load more posts
* 📊 Aggregate posts from multiple JSON sources
* 💾 XML backup of feed data
* 📄 XML feed viewer using XSLT
* ⚙️ Settings and feed management
* 📱 Mobile-friendly interface

## 🛠️ Technologies Used

| Technology      | Purpose                                  |
| --------------- | ---------------------------------------- |
| PHP             | Backend processing and API handling      |
| AngularJS 1.8.2 | Dynamic feed and UI interaction          |
| jQuery          | Like, comment and other DOM interactions |
| JSON            | Social media feed data                   |
| XML             | Feed backup storage                      |
| XSLT            | XML data presentation                    |
| HTML5           | Web page structure                       |
| CSS3            | Styling and responsive design            |
| XAMPP           | Local development server                 |

## 📂 Project Structure

```text
SocialSphere/
│
├── angular/
│   └── app.js
│
├── api/
│   ├── aggregate.php
│   └── backup.php
│
├── backup/
│   └── feed_backup.xml
│
├── css/
│   └── style.css
│
├── data/
│   ├── education.json
│   ├── technology.json
│   └── travel.json
│
├── js/
│   └── jquery-functions.js
│
├── xslt/
│   └── feed.xsl
│
├── index.php
└── xml-viewer.php
```

## 🚀 How to Run

### 1. Install XAMPP

Install XAMPP and start:

* Apache

### 2. Copy the Project

Place the project inside:

```text
C:\xampp\htdocs\SocialSphere
```

### 3. Start the Application

Open your browser and visit:

```text
http://localhost/SocialSphere/
```

## 🔄 Data Flow

```text
JSON Data Sources
       ↓
PHP Aggregator
       ↓
Combined Feed
       ↓
AngularJS Interface
       ↓
Search / Filter / Like / Comment / Save
       ↓
XML Backup
       ↓
XSLT XML Viewer
```

## 📌 Main Modules

### Feed Aggregation

PHP collects posts from multiple JSON sources and combines them into a single feed.

### Search & Filtering

Users can search for posts and filter them based on categories such as Education, Technology, Travel and Entertainment.

### User Interactions

Users can:

* Like posts
* Add comments
* Save posts
* View saved posts

### XML Backup

The aggregated feed can be stored as an XML backup for data preservation.

### XSLT Viewer

The XML backup can be transformed and displayed using XSLT.

## 🎯 Project Objective

The main objective of SocialSphere is to demonstrate how data from multiple sources can be aggregated, processed and presented through a single responsive web interface using different web technologies.

## 🔮 Future Enhancements

* User authentication
* Real social media API integration
* Database integration
* Real-time notifications
* Advanced recommendation system
* Admin dashboard
* Cloud deployment

## 👩‍💻 Developer

**Abinaya Shree**

MCA – Final Year

## 📄 License

This project is developed for **academic and educational purposes**.
