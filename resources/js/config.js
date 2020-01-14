/**
 * Defines the API route we are using.
 */
var api_url = '';
var google_maps_js_api = 'AIzaSyAnXyuW1mKEr1rMb383rD7gEVYV-pY9XnE';

switch( process.env.NODE_ENV ){
  case 'development':
    api_url = 'http://localhost:8000/api/v1';
  break;
  case 'production':
    api_url = 'https://roastandbrew.coffee/api/v1';
  break;
}

export const ROAST_CONFIG = {
  API_URL: api_url,
}
