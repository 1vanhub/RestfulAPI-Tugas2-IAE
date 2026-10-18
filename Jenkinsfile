pipeline {
    agent any
    environment {
        IMAGE_NAME = '1vanaja/restful-api-iae'
        REGISTRY_CREDENTIALS = 'dockerhub-credentials'
    }
    stages {
        stage('Checkout') {
            steps {
                echo 'Melakukan checkout dari SCM...'
                checkout scm
            }
        }
        stage('Build Docker Image') {
            steps {
                echo 'Membangun Docker image untuk Laravel API...'
                bat "docker build -t %IMAGE_NAME%:%BUILD_NUMBER% ."
            }
        }
        stage('Push Docker Image') {
            steps {
                echo 'Mengunggah image ke Docker Hub...'
                withCredentials([usernamePassword(credentialsId: REGISTRY_CREDENTIALS,
                    usernameVariable: 'USER', passwordVariable: 'PASS')]) {
                    bat 'docker login -u %USER% -p %PASS%'
                    bat "docker push %IMAGE_NAME%:%BUILD_NUMBER%"
                    bat "docker tag %IMAGE_NAME%:%BUILD_NUMBER% %IMAGE_NAME%:latest"
                    bat "docker push %IMAGE_NAME%:latest"
                }
            }
        }
    }
    post {
        always {
            echo 'Selesai menjalankan pipeline!'
        }
    }
}
