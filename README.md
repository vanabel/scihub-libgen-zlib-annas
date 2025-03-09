
# scihub-libgen-zlib-annas

## Overview
This project aims to test the connectivity of various websites related to Sci-Hub, Library Genesis, Z-Library, and Anna's Archive. It provides a simple interface to check the availability of these websites from your location and extract metadata from their content.

## Purpose
- **Free Access to Knowledge**: Sci-Hub, Library Genesis, Z-Library, and Anna's Archive are platforms that provide free access to scientific and academic content. This project helps users verify the availability of these platforms.
- **Connectivity Testing**: The script tests the connectivity of multiple URLs and provides response times and metadata extraction results.
- **Custom URL Testing**: Users can add custom URLs to test additional sites.

## Features
- **Automated Connectivity Testing**: The script tests predefined URLs for Sci-Hub, Library Genesis, Z-Library, and Anna's Archive.
- **Metadata Extraction**: Extracts titles and descriptions from the tested websites.
- **Custom URL Submission**: Allows users to add custom URLs for testing.
- **Response Time Measurement**: Measures and displays the response time for each tested URL.
- **Sorting Functionality**: Sorts the results by response time for easier analysis.

## How to Use
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/your-username/scihub-libgen-zlib-annas.git 
   cd scihub-libgen-zlib-annas
   ```

2. **Set Up the Environment**:
   - Ensure you have a PHP server environment set up (e.g., XAMPP, WAMP, or a local PHP server).
   - Place the script files in the web server's root directory (e.g., `htdocs` for XAMPP).

3. **Run the Script**:
   - Access the script via your web browser (e.g., `http://localhost/scihub-libgen-zlib-annas/`).
   - Choose the platform to test (Sci-Hub, Library Genesis, Z-Library, Anna's Archive) or test custom URLs.

4. **Interact with the Interface**:
   - The script will display the status of each URL, along with response times and extracted metadata.
   - You can add custom URLs for testing and remove them if needed.
   - Click the "Response Time" header to sort the results by response time.

## Dependencies
- PHP (for server-side processing)
- jQuery (for AJAX requests and DOM manipulation)
- Bootstrap (for styling the interface)

## Contributing
Feel free to contribute to this project by submitting pull requests or reporting issues. Contributions are welcome!

## License
This project is licensed under the [MIT License](LICENSE).

---

### Notes:
1. **Legal Considerations**: Be aware that the use of Sci-Hub, Library Genesis, and similar platforms may be subject to legal restrictions in your jurisdiction. This project is intended for educational purposes only.
2. **Customization**: You can modify the predefined URLs in the script to include additional sites or remove existing ones.
