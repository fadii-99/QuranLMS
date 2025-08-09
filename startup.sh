#!/bin/bash

# Quran LMS Smart Classroom Startup Script
# ========================================

echo "🚀 Starting Quran LMS Smart Classroom System"
echo "============================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Check if Python 3 is installed
if ! command -v python3 &> /dev/null; then
    echo -e "${RED}❌ Python 3 is not installed. Please install Python 3.8 or higher.${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Python 3 found: $(python3 --version)${NC}"

# Check if pip is installed
if ! command -v pip3 &> /dev/null; then
    echo -e "${RED}❌ pip3 is not installed. Please install pip3.${NC}"
    exit 1
fi

echo -e "${GREEN}✅ pip3 found${NC}"

# Create virtual environment if it doesn't exist
if [ ! -d "venv" ]; then
    echo -e "${YELLOW}📦 Creating Python virtual environment...${NC}"
    python3 -m venv venv
fi

# Activate virtual environment
echo -e "${YELLOW}🔧 Activating virtual environment...${NC}"
source venv/bin/activate

# Install/upgrade pip
echo -e "${YELLOW}⬆️ Upgrading pip...${NC}"
pip install --upgrade pip

# Install requirements
echo -e "${YELLOW}📥 Installing Python dependencies...${NC}"
pip install -r requirements.txt

# Check if all dependencies are installed
echo -e "${YELLOW}🔍 Checking dependencies...${NC}"

# List of critical packages
PACKAGES=("fastapi" "uvicorn" "websockets" "pydantic")

for package in "${PACKAGES[@]}"; do
    if pip show "$package" > /dev/null 2>&1; then
        echo -e "${GREEN}  ✅ $package${NC}"
    else
        echo -e "${RED}  ❌ $package not found${NC}"
        echo -e "${YELLOW}  Installing $package...${NC}"
        pip install "$package"
    fi
done

# Make sure the Python files are executable
chmod +x python_class_generator.py
chmod +x classroom_api_server.py

echo ""
echo -e "${BLUE}🎓 Quran LMS Smart Classroom System${NC}"
echo -e "${BLUE}====================================${NC}"
echo ""

# Function to start the Python API server
start_api_server() {
    echo -e "${YELLOW}🔥 Starting Python FastAPI Server...${NC}"
    echo -e "${BLUE}📡 WebSocket & REST API: http://localhost:8000${NC}"
    echo -e "${BLUE}📊 API Documentation: http://localhost:8000/docs${NC}"
    echo -e "${BLUE}🔌 WebSocket Endpoint: ws://localhost:8000/ws/{room_code}${NC}"
    echo ""
    
    # Start the FastAPI server
    python3 classroom_api_server.py
}

# Function to test the system
test_system() {
    echo -e "${YELLOW}🧪 Testing the system...${NC}"
    python3 python_class_generator.py
    echo -e "${GREEN}✅ System test completed${NC}"
}

# Menu for user choice
echo "Choose an option:"
echo "1) Start the Smart Classroom API Server"
echo "2) Test the System"  
echo "3) Install/Update Dependencies Only"
echo "4) Show System Information"

read -p "Enter your choice (1-4): " choice

case $choice in
    1)
        start_api_server
        ;;
    2)
        test_system
        ;;
    3)
        echo -e "${GREEN}✅ Dependencies installed/updated successfully${NC}"
        ;;
    4)
        echo ""
        echo -e "${BLUE}📋 System Information${NC}"
        echo "===================="
        echo -e "Python Version: $(python3 --version)"
        echo -e "Virtual Environment: $(which python3)"
        echo -e "Working Directory: $(pwd)"
        echo ""
        echo -e "${BLUE}📦 Installed Packages:${NC}"
        pip list | head -20
        echo ""
        echo -e "${BLUE}🚀 To start the server:${NC}"
        echo "./startup.sh and choose option 1"
        echo ""
        echo -e "${BLUE}🌐 Laravel Integration:${NC}"
        echo "Make sure your Laravel server is running on http://localhost:8000"
        echo "Update your .env file with PYTHON_API_URL=http://localhost:8000"
        ;;
    *)
        echo -e "${RED}❌ Invalid choice${NC}"
        exit 1
        ;;
esac

echo ""
echo -e "${GREEN}🎉 Process completed!${NC}"

# Deactivate virtual environment
deactivate 2>/dev/null || true
