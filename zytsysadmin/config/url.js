import env from './env'

// const DEV_URL = 'https://www.easy-mock.com/mock/5add9213ce4d0e69998a6f51/iview-admin/'
// const PRO_URL = 'https://produce.com'
// const DEV_URL = 'http://localhost:802/onehre/admin.php'
const DEV_URL = '/zhuyingtai/admin.php'
const PRO_URL = 'http://www.bamoke.com/zhuyingtai/admin.php'

export default env === 'development' ? DEV_URL : PRO_URL
