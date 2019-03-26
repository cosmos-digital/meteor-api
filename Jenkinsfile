pipeline {
  agent any
  stages {
    stage('build') {
      steps {
        sh 'echo ${PWD}'
        sh 'echo ${JOB_NAME}'
        sh 'ls'
        sh 'mkdir var && chmod 777 var/ -R'
      }
    }
    stage('Deploy'){
      steps{
        stash name: 'api-stash', includes: '**'
        dir('/data/meteor/data/php/api/www') {
            unstash 'api-stash'
        }
      }
    }
  }
  post { 
    always { 
      cleanWs()
    }
  }
}