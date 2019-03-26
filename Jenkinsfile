pipeline {
  agent any
  stages {
    stage('build') {
      steps {
        sh 'echo ${PWD}'
        sh 'echo ${JOB_NAME}'
        sh 'ls'
      }
    }
    stage('Deploy'){
      steps{
        stash name: 'api-stash', includes: '**'
        dir('/data/meteor/data/php/api/www') {
            sh 'mkdir var && chmod 666 var/ -R'
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