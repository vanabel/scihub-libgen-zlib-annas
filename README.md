# scihub-libgen-zlib-annas

[English](#english) | [中文](#chinese)

---

## English

### Overview
This project aims to test the connectivity of various websites related to Sci-Hub, Library Genesis, Z-Library, and Anna's Archive. It provides a simple interface to check the availability of these websites from your location and extract metadata from their content.

### Purpose
- **Free Access to Knowledge**: Sci-Hub, Library Genesis, Z-Library, and Anna's Archive are platforms that provide free access to scientific and academic content. This project helps users verify the availability of these platforms.
- **Connectivity Testing**: The script tests the connectivity of multiple URLs and provides response times and metadata extraction results.
- **Custom URL Testing**: Users can add custom URLs to test additional sites.

### Features
- **Automated Connectivity Testing**: The script tests predefined URLs for Sci-Hub, Library Genesis, Z-Library, and Anna's Archive.
- **Metadata Extraction**: Extracts titles and descriptions from the tested websites.
- **Custom URL Submission**: Allows users to add custom URLs for testing.
- **Response Time Measurement**: Measures and displays the response time for each tested URL.
- **Sorting Functionality**: Sorts the results by response time for easier analysis.

### How to Use
1. **Download the `index.php` File**:
   - Download the `index.php` file from the [repository](https://github.com/your-username/scihub-libgen-zlib-annas ).
   - Place it in the root directory of your web app.

2. **Test Connectivity**:
  ```html
   <a href="index.php?test=scihub" target="_blank">Test Sci-Hub Connectivity</a><br>
   <a href="index.php?test=libgen" target="_blank">Test Library Genesis Connectivity</a><br>
   <a href="index.php?test=zlibrary" target="_blank">Test Z-Library Connectivity</a><br>
   <a href="index.php?test=annas" target="_blank">Test Anna's Archive Connectivity</a>
  ```
3. **Add Custom URLs for Testing**:
   - You can add custom URLs by visiting `index.php` directly and entering the URL in the provided form.

### Dependencies
- PHP (for server-side processing)
- jQuery (for AJAX requests and DOM manipulation)
- Bootstrap (for styling the interface)

### Contributing
Feel free to contribute to this project by submitting pull requests or reporting issues. Contributions are welcome!

### License
This project is licensed under the [MIT License](LICENSE).

---

## Chinese

### 概述
该项目旨在测试与 Sci-Hub、Library Genesis、Z-Library 和 Anna's Archive 相关的各个网站的连通性。它提供了一个简单的界面，用于检查这些网站在您所在位置的可用性，并提取其内容的元数据。

### 目的
- **免费获取知识**：Sci-Hub、Library Genesis、Z-Library 和 Anna's Archive 是提供免费科学和学术内容的平台。此项目帮助用户验证这些平台的可用性。
- **连通性测试**：该脚本测试多个 URL 的连通性，并提供响应时间和元数据提取结果。
- **自定义 URL 测试**：用户可以添加自定义 URL 以测试其他网站。

### 功能
- **自动化连通性测试**：脚本测试 Sci-Hub、Library Genesis、Z-Library 和 Anna's Archive 的预定义 URL。
- **元数据提取**：提取测试网站的标题和描述。
- **自定义 URL 提交**：允许用户添加自定义 URL 进行测试。
- **响应时间测量**：测量并显示每个测试 URL 的响应时间。
- **排序功能**：按响应时间对结果进行排序，便于分析。

### 使用方法
1. **下载 `index.php` 文件**：
   - 从 [仓库](https://github.com/your-username/scihub-libgen-zlib-annas ) 下载 `index.php` 文件。
   - 将其放置在您的 Web 应用的根目录中。

2. **测试连通性**：
  ```html
  <a href="index.php?test=scihub" target="_blank">测试 Sci-Hub 连通性</a><br>
  <a href="index.php?test=libgen" target="_blank">测试 Library Genesis 连通性</a><br>
  <a href="index.php?test=zlibrary" target="_blank">测试 Z-Library 连通性</a><br>
  <a href="index.php?test=annas" target="_blank">测试 Anna's Archive 连通性</a>
  ```
3. **添加自定义 URL 进行测试**：
   - 您可以通过直接访问 `index.php`，并在提供的表单中输入 URL 来添加自定义 URL。

### 依赖项
- PHP（用于服务器端处理）
- jQuery（用于 AJAX 请求和 DOM 操作）
- Bootstrap（用于界面样式设计）

### 贡献指南
欢迎通过提交拉取请求或报告问题来为该项目做出贡献。您的贡献将不胜感激！

### 许可证
该项目遵循 [MIT License](LICENSE) 许可证。

---

### 注意事项
1. **法律考量**  
   请注意，使用 Sci-Hub、Library Genesis 等平台可能受到您所在地区的法律限制。该项目仅供教育用途。
2. **自定义**  
   您可以修改脚本中的预定义 URL，以添加其他网站或删除现有网站。
