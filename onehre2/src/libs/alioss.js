import config from '@/config'
import AliOss from 'ali-oss'
const {accessKeyId, accessKeySecret, bucket, region} = config.aliOss
const OSS = new AliOss({
  accessKeyId,
  accessKeySecret,
  bucket,
  region
})
export default OSS
