#!/bin/bash

# Target: Linux AMD64 (Standard for most web servers)
# We name it .cgi so the .htaccess AddHandler picks it up automatically.

echo "Building portfolio for Linux AMD64 (Optimized Static CGI)..."
CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build -ldflags="-s -w" -o portfolio.cgi main.go

if [ $? -eq 0 ]; then
    echo "------------------------------------------------"
    echo "SUCCESS: 'portfolio.cgi' created."
    echo ""
    echo "Next steps for Hostinger:"
    echo "1. Upload these files to your 'public_html' folder:"
    echo "   - portfolio.cgi"
    echo "   - .htaccess"
    echo "   - static/ (entire folder)"
    echo "   - templates/ (entire folder)"
    echo "2. Use Hostinger File Manager to set 'portfolio.cgi' permissions to 755 (Executable)."
    echo "------------------------------------------------"
else
    echo "Error: Build failed."
    exit 1
fi
